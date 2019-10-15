<?php
namespace Piv\Guestbook\Helpers;

use \DateTime;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\EntityManager;
use Piv\Guestbook\Config\Config;
use Piv\Guestbook\Entity\Message;
use Piv\Guestbook\Entity\User;
use Piv\Guestbook\Forms\UserType;
use Piv\Guestbook\Helpers\File\FactoryPictures;
use Piv\Guestbook\Helpers\File\FileTxt;

class GuestBookFormer
{

    protected $entityManager;
    protected $request;
    protected $user;
    protected $message;
    protected $form;

    public function __construct(Request $request, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;

        $this->user = new User();
        $this->message = new Message();
        $this->user->getMessages()->add($this->message);
    }

    public function createForm()
    {
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new ValidatorExtension(Validation::createValidator()))
            ->getFormFactory();
        $this->form = $formFactory->createBuilder(UserType::class, $this->user)->getForm();
    }

    public function getForm()
    {
        return $this->form;
    }

    public function isFormSubmittedAndValid(): bool
    {
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $recaptchaResponse = $this->request->request->get('g-recaptcha-response');
            if (!empty($recaptchaResponse)) {
                $captchaUrl= Config::getGlobalVariableEnv('GUESTBOOK_CAPTCHA_URL');
                $captchaSecret = Config::getGlobalVariableEnv('GUESTBOOK_CAPTCHA_SECRET');
                $url = $captchaUrl . "?secret="
                    . $captchaSecret . "&response="
                    . $recaptchaResponse . "&remoteip="
                    . $this->request->server->get('REMOTE_ADDR');
                $rsp = file_get_contents($url);
                $captchaData = json_decode($rsp, true);
                if ($captchaData['success']) {
                    return true;
                }
            }
        }

        return false;
    }

    public function addMessage()
    {
        $this->message->setIp($this->request->server->get('REMOTE_ADDR'));
        $this->message->setBrowser($this->request->server->get('HTTP_USER_AGENT'));
        $this->message->setDate(new DateTime("now"));
        // загрузка изображения
        $imagePictureFile = $this->request->files->get('user')['messages']['0']['pictures'];
        if ($imagePictureFile && $imagePictureFile->getClientOriginalName() !== '') {
            $factory = new FactoryPictures();
            $image = $factory->createImage($imagePictureFile);
            $image->moveImageTo($_ENV['DIR_TEMP_UPLOAD']);
            $image->createImage(
                $_ENV['DIR_TEMP_UPLOAD'],
                $_ENV['DIR_IMAGE_UPLOAD'],
                320,
                240
            );
            $image->createImage(
                $_ENV['DIR_TEMP_UPLOAD'],
                $_ENV['DIR_SMALL_IMAGE_UPLOAD'],
                60,
                50
            );
            $image->deleteFileFrom($_ENV['DIR_TEMP_UPLOAD']);
            $this->message->setPictures($image->getImage()->getClientOriginalName());
        }
        // загрузка текстового файла
        $imageTxtFile = $this->request->files->get('user')['messages']['0']['filepath'];
        $this->message->setFilepath('');
        if ($imageTxtFile && $imageTxtFile->getClientOriginalName() !== '') {
            $file = new FileTxt($imageTxtFile);
            $file->moveFileTo($_ENV['DIR_FILE_TXT_UPLOAD']);
            $this->message->setFilepath($file->getFile()->getClientOriginalName());
        }

        $usersRepository = $this->entityManager->getRepository(User::class);
        $isUser = $usersRepository->findOneBy([
            'name' => $this->request->request->get('user')['name'],
            'email' => $this->request->request->get('user')['email']
        ]);
        $this->user = isset($isUser) ? $isUser : $this->user;
        $this->message->setUser($this->user);
        $this->entityManager->persist($this->message);
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }

    public function getAllMessages(): array
    {
        // получение сообщений из БД
        $messagesRepository = $this->entityManager->getRepository(Message::class);
        return $messagesRepository->findAll();

    }
}
