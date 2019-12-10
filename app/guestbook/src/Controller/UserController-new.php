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
        $user = new User();
        $message = new Message();
        $user->getMessages()->add($message);

        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new ValidatorExtension(Validation::createValidator()))
            ->getFormFactory();
        $form = $formFactory->createBuilder(UserType::class, $user)->getForm();
        $form->handleRequest($request);

        $guestBookFormer = new GuestBookFormer($request, $this->getDoctrine()->getManager());
        if ($guestBookFormer->isFormSubmittedAndValid($form) === true) {
            $guestBookFormer->addMessage($message, $user);
        }
        //$messages = $guestBookFormer->getAllMessages();
        preg_match('/(Date|Username|Email)(Asc|Desc)/i', $sortflag, $matches);
        $messages = $guestBookFormer->getMessagesBy(
            ['annotationForId' => 0],
            [$matches[1] => $matches[2]]
        );
        foreach ($messages as $message) {
            $annotations = $guestBookFormer->getMessagesBy(
                ['annotationForId' => $message->getId()],
                ['date' => 'desc']
            );
            $messagesAnnotations [] = [$message, $annotations];
        }
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
