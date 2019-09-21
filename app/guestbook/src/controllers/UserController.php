<?php
namespace Piv\Guestbook\Src\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Piv\Guestbook\Src\Twig\Twig;
use Piv\Guestbook\Src\Helpers\GuestBookFormer;
use Piv\Guestbook\Src\Container\ServiceContainer;

class UserController
{
    public static function show(Request $request, string $sortFlag = 'ByDateDesc', string $count = '1', Twig $twig): Response
    {
        //$container = new ServiceContainer();
        //$twig = $container->get()->get('twig');
        $guestBookFormer = new GuestBookFormer($request);
        $guestBookFormer->createForm();
        $guestBookFormer->getForm()->handleRequest($request);
        if ($guestBookFormer->isFormSubmittedAndValid() === true) {
            //var_dump($guestBookFormer);
            $guestBookFormer->addMessage();
        }
        $messages = $guestBookFormer->getAllMessages();
        // формирование контента
        $content = $twig->getTwig()->render(
            'user/index.html.twig',
            [
                'form' => $guestBookFormer->getForm()->createView(),
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
