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
        $action = $request->request->get('action');
        //$result = $guestBookFormer->$action();
        if (!strcmp($action, 'addAnnotation') {
            $result = $guestBookFormer->addAnnotation(
                [
                    'id' => $request->request->get('message'),
                    'text' => $request->request->get('text')

                ]
            );
        } elseif (!strcmp($action, 'editMessage') {
            $result = $guestBookFormer->addAnnotation(
                [
                    'id' => $request->request->get('message'),
                    'text' => $request->request->get('text'),
                    'theme' => $request->request->get('theme'),
                ]
            );
          } elseif (!strcmp($action, 'deleteMessage') {
              $result = $guestBookFormer->addAnnotation(
                  [
                      'id' => $request->request->get('message'),
                  ]
              );
          }
        $content = $this->render(
            'admin/admin-result.html.twig',
            [
                'result' => $result,
            ]
        );

        $response = new Response($content);
        return $response;
    }
}
