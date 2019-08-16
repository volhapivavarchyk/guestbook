<?php
namespace Piv\Guestbook\App\Controllers;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Extension\Core\Type\{DateType, SubmitType, TextType};
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Validator\Validation;

use Piv\Guestbook\App\Twig\Twig;
use Piv\Guestbook\App\Forms\{MessageType, UserType};
use Piv\Guestbook\App\Config\{Config, Bootstrap};
use Piv\Guestbook\App\Entities\{Message, User};
use Piv\Guestbook\App\Controllers\UploadedFiles\{ImageFactory, FileTxt};

class MessageController
{
    public function show(Request $request): Response
    {
        /*
        $containerBuilder = new ContainerBuilder();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__));
        $loader->load('services.yaml');
        $this->setContainer($containerBuilder);
        */
        $entityManager = (new Bootstrap())->getEntityManager();
        $addedMessage = '';
        // обработка формы для ввода сообщения
        $user = new User();
        $message = new Message();
        $user->getMessages()->add($message);
        $twig = new Twig();
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new ValidatorExtension(Validation::createValidator()))
            ->getFormFactory();
        $form = $formFactory->createBuilder(UserType::class, $user)
            ->getForm();
        var_dump($message);
        $form->handleRequest($request);
        var_dump($message);
        // обработка капчи
        if ($form->isSubmitted() && $form->isValid()) {
            $addedMessage = "Сообщение не добавлено. Не введена капча";
            $recaptchaResponse = $request->request->get('g-recaptcha-response');
            if (!empty($recaptchaResponse)) {
                $captcha_url = $_ENV['GUESTBOOK_CAPTCHA_URL'];
                $captcha_secret = $_ENV['GUESTBOOK_CAPTCHA_SECRET'];
                $url = $captcha_url . "?secret=" . $captcha_secret . "&response=" . $recaptchaResponse . "&remoteip=" . $request->server->get('REMOTE_ADDR');
                $rsp = file_get_contents($url);
                $captchaData = json_decode($rsp, true);
                $addedMessage = "Сообщение не добавлено. Неверно введена капча";
            }
            if ($captchaData['success']) {
                $message->setIp($request->server->get('REMOTE_ADDR'));
                $message->setBrowser($request->server->get('HTTP_USER_AGENT'));
                $message->setDate(new \DateTime("now"));
                // загрузка изображения
                $imagePictureFile = $request->files->get('user')['messages']['0']['pictures'];
                if ($imagePictureFile && $imagePictureFile->getClientOriginalName() !== '') {
                    $factory = new ImageFactory();
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
                if ($imageTxtFile && $imageTxtFile->getClientOriginalName() !== '') {
                    $file = new FileTxt($imageTxtFile);
                    $file->moveFileTo(Config::DIR_FILE_TXT_UPLOAD);
                    $message->setFilepath($file->getFile()->getClientOriginalName());
                } else {
                    $message->setFilepath('');
                }

                $usersRepository = $entityManager->getRepository(User::class);
                $isUser = $usersRepository->findOneBy([
                    'name' => $request->request->get('user')['name'],
                    'email' => $request->request->get('user')['email']
                ]);
                if (isset($isUser)) {
                    $user = $isUser;
                }
                $message->setUser($user);
                $entityManager->persist($message);
                $entityManager->persist($user);
                $entityManager->flush();
                $addedMessage = "Сообщение добавлено";
            }
        }
        // получение сообщений из БД
        $messagesRepository = $entityManager->getRepository(Message::class);
        $messages = $messagesRepository->findAll();
        // параметры сортировки и отображения
        $sortFlag = !empty($request->query->get('sortflag')) ? $request->query->get('sortflag') : 'ByDateDesc';
        $count = !empty($request->query->get('count')) ? $request->query->get('count') : 1;
        // формирование контента
        $content = $twig->getTwig()->render(
            'index.html.twig',
            [
                'form' => $form->createView(),
                'messages' => $messages,
                'addedMessage' => $addedMessage,
                'sortflag' => $sortFlag,
                'count' => $count,
            ]
        );
        $response = new Response(
            $content,
        );
        $response->headers->addCacheControlDirective('no-store', true);
        $response->headers->addCacheControlDirective('no-cache', true);
        return $response;
    }
}
