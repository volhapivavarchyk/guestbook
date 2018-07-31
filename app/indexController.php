<?php
namespace Pi\Guestbook\App;

use Pi\Guestbook\App\AController as AController;
use Pi\Guestbook\Database\Message;

class IndexController extends AController
{
    public $tMessage;

    public function __construct()
    {
        $this->tMessage = new Message();
    }

    public function getBody($sort)
    {
        $messages = $this->tMessage->getAllItems($sort);
        $this->render('indexView', [
            'sort' => $sort,
            'messages' => $messages
        ]);
    }

    public function addMessage($params)
    {
        $messages = $this->tMessage->addItem($params);
    }
}
