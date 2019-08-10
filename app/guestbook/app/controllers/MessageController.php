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

use Piv\Guestbook\App\Config\Twig;
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
            ->getFormFactory();
        $form = $formFactory->createBuilder(UserType::class, $user)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setIp($request->server->get('REMOTE_ADDR'));
            $message->setBrowser($request->server->get('HTTP_USER_AGENT'));
            $message->setDate(new \DateTime("now"));
            // загрузка изображения
            $imagePictureFile = $request->files->get('user')['messages']['0']['pictures'];
            if ($imagePictureFile->getClientOriginalName() !== '') {
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
            if ($imageTxtFile->getClientOriginalName() !== '') {
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
            $addedMessage = "Сообщение успешно добавлено";
        }
        // получение сообщений из БД
        $messagesRepository = $entityManager->getRepository(Message::class);
        $messages = $messagesRepository->findAll();
        // формирование контента
        $content = $twig->getTwig()->render(
            'index.html.twig',
            [
                'books' => $books,
                'form' => $form->createView(),
                'messages' => $messages,
                'addedMessage' => $addedMessage
            ]
        );
        $response = new Response($content);
        return $response;
    }
}
