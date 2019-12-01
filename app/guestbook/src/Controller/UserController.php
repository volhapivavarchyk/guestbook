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
        //$messages = $guestBookFormer->getAllMessages();
        preg_match('/(Date|Username|Email)(Asc|Desc)/i', $sortflag, $matches);
        $matches[1] = mb_strtolower($matches[1]);
        $messages = $guestBookFormer->getMessagesBy(
            ['annotationForId' => 0],
            [$matches[1] => $matches[2]]
        );
        var_dump($messages[19]->getUser());
        foreach ($messages as $message) {
            $annotations = $guestBookFormer->getMessagesBy(
                ['annotationForId' => $message->getId()],
                ['date' => 'desc']
            );
            $messagesAnnotations [] = [$message, $annotations];
        }
        //var_dump($messagesAnnotations);
        // формирование контента
        $content = $this->render(
            'user/user.html.twig',
            [
                'form' => $guestBookFormer->getForm()->createView(),
                'messages' => $messagesAnnotations,
                'sortflag' => $sortflag,
                'count' => (int)$count,
                'captchaKey' => $_ENV['GUESTBOOK_CAPTCHA_KEY'],
            ]
        );
        $response = new Response($content);
        return $response;
    }
}
