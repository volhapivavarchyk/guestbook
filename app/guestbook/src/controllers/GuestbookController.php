<?php
namespace Piv\Guestbook\Src\Controllers;

use \DateTime;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;
use Piv\Guestbook\Src\Twig\Twig;
use Piv\Guestbook\Src\Forms\UserType;
use Piv\Guestbook\Config\Config;
use Piv\Guestbook\Config\Bootstrap;
use Piv\Guestbook\Src\Entities\Message;
use Piv\Guestbook\Src\Entities\User;
use Piv\Guestbook\Src\Helpers\File\FactoryPictures;
use Piv\Guestbook\Src\Helpers\File\FileTxt;

class GuestbookController
{
    public static function show(Request $request, string $sortFlag = 'ByDateDesc', string $count = '1'): Response
    {
        $entityManager = (new Bootstrap())->getEntityManager();
        // обработка формы для ввода сообщения
        $user = new User();
        $message = new Message();
        $user->getMessages()->add($message);
        $twig = new Twig();
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new ValidatorExtension(Validation::createValidator()))
            ->getFormFactory();
        $form = $formFactory->createBuilder(UserType::class, $user)->getForm();
        $form->handleRequest($request);
        // обработка капчи
        if ($form->isSubmitted() && $form->isValid()) {
            $recaptchaResponse = $request->request->get('g-recaptcha-response');
            if (!empty($recaptchaResponse)) {
                $captchaUrl= $_ENV['GUESTBOOK_CAPTCHA_URL'];
                $captchaSecret = $_ENV['GUESTBOOK_CAPTCHA_SECRET'];
                $url = $captchaUrl . "?secret="
                    . $captchaSecret . "&response="
                    . $recaptchaResponse . "&remoteip="
                    . $request->server->get('REMOTE_ADDR');
                $rsp = file_get_contents($url);
                $captchaData = json_decode($rsp, true);
                if ($captchaData['success']) {
                    $message->setIp($request->server->get('REMOTE_ADDR'));
                    $message->setBrowser($request->server->get('HTTP_USER_AGENT'));
                    $message->setDate(new DateTime("now"));
                    // загрузка изображения
                    $imagePictureFile = $request->files->get('user')['messages']['0']['pictures'];
                    if ($imagePictureFile && $imagePictureFile->getClientOriginalName() !== '') {
                        $factory = new FactoryPictures();
                        $image = $factory->createImage($imagePictureFile);
                        $image->moveImageTo(Config::DIR_TEMP_UPLOAD);
                        $image->createImage(
                            Config::DIR_TEMP_UPLOAD,
                            Config::DIR_IMAGE_UPLOAD,
                            320,
                            240
                        );
                        $image->createImage(
                            Config::DIR_TEMP_UPLOAD,
                            Config::DIR_SMALL_IMAGE_UPLOAD,
                            60,
                            50
                        );
                        $image->deleteFileFrom(Config::DIR_TEMP_UPLOAD);
                        $message->setPictures($image->getImage()->getClientOriginalName());
                    }
                    // загрузка текстового файла
                    $imageTxtFile = $request->files->get('user')['messages']['0']['filepath'];
                    $message->setFilepath('');
                    if ($imageTxtFile && $imageTxtFile->getClientOriginalName() !== '') {
                        $file = new FileTxt($imageTxtFile);
                        $file->moveFileTo(Config::DIR_FILE_TXT_UPLOAD);
                        $message->setFilepath($file->getFile()->getClientOriginalName());
                    }

                    $usersRepository = $entityManager->getRepository(User::class);
                    $isUser = $usersRepository->findOneBy([
                        'name' => $request->request->get('user')['name'],
                        'email' => $request->request->get('user')['email']
                    ]);
                    $user = isset($isUser) ? $isUser : $user;
                    $message->setUser($user);
                    $entityManager->persist($message);
                    $entityManager->persist($user);
                    $entityManager->flush();
                }
            }
        }
        // получение сообщений из БД
        $messagesRepository = $entityManager->getRepository(Message::class);
        $messages = $messagesRepository->findAll();
        // формирование контента
        $content = $twig->getTwig()->render(
            'index.html.twig',
            [
                'form' => $form->createView(),
                'messages' => $messages,
                'sortflag' => $sortFlag,
                'count' => (int)$count,
                'captchaKey' => $_ENV['GUESTBOOK_CAPTCHA_KEY'],
            ]
        );
        $response = new Response($content);
        return $response;
    }
}
