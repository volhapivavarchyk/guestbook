<?php
namespace Piv\Guestbook\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Piv\Guestbook\Helpers\GuestBookFormer;

class AdminController extends Controller
{
    public function adminDashboard(Request $request, string $sortflag, string $count): Response
    {
        $guestBookFormer = new GuestBookFormer($request, $this->getDoctrine()->getManager());
        preg_match('/(Date|Username|Email)(Asc|Desc)/i', $sortflag, $matches);
        $messages = $guestBookFormer->getMessagesBy(
            ['annotationForId' => 0],
            [$matches[1] => $matches[2]]
        );
        //var_dump($messages[1]->getUser());
        foreach ($messages as $message) {
            $annotations = $guestBookFormer->getMessagesBy(
                ['annotationForId' => $message->getId()],
                ['date' => 'desc']
            );
            $messagesAnnotations [] = [$message, $annotations];
        }
        // формирование контента
        $content = $this->render(
            'admin/admin.html.twig',
            [
                'messages' => $messagesAnnotations,
                'sortflag' => $sortflag,
                'count' => (int)$count,
            ]
        );
        $response = new Response($content);
        return $response;
    }

    public function adminAction(Request $request): Response
    {
        $guestBookFormer = new GuestBookFormer($request, $this->getDoctrine()->getManager());


        preg_match('/(Date|Username|Email)(Asc|Desc)/i', $sortflag, $matches);
        $messages = $guestBookFormer->getMessagesBy(
            ['annotationForId' => 0],
            [$matches[1] => $matches[2]]
        );
        //var_dump($messages[1]->getUser());
        foreach ($messages as $message) {
            $annotations = $guestBookFormer->getMessagesBy(
                ['annotationForId' => $message->getId()],
                ['date' => 'desc']
            );
            $messagesAnnotations [] = [$message, $annotations];
        }
        // формирование контента
        $content = $this->render(
            'admin/admin.html.twig',
            [
                'messages' => $messagesAnnotations,
                'sortflag' => $sortflag,
                'count' => (int)$count,
            ]
        );
        $response = new Response($content);
        return $response;
    }

}
