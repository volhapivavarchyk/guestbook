<?php
namespace Piv\Guestbook\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Piv\Guestbook\Helpers\GuestBookFormer;
use Piv\Guestbook\Entity\Message;

class UserController extends Controller
{
    public function show(Request $request, string $sortflag, string $count): Response
    {
        $guestBookFormer = new GuestBookFormer($request, $this->getDoctrine()->getManager());
        $guestBookFormer->createForm();
        $guestBookFormer->getForm()->handleRequest($request);
        if ($guestBookFormer->isFormSubmittedAndValid() === true) {
            $guestBookFormer->addMessage();
        }
        $messages = $guestBookFormer->getAllMessages();
        // формирование контента
        $content = $this->render(
            'user.html.twig',
            [
                'form' => $guestBookFormer->getForm()->createView(),
                'messages' => $messages,
                'sortflag' => $sortflag,
                'count' => (int)$count,
                'captchaKey' => $_ENV['GUESTBOOK_CAPTCHA_KEY'],
            ]
        );
        $response = new Response($content);
        return $response;
    }
}
