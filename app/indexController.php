<?php
namespace Pi\Guesbook\App;

use Pi\Guesbook\App\AController as AController;
use Pi\Guesbook\Database\Message;

class IndexController extends AController
{
    public $tMessage;

    public function __construct()
    {
        $this->tMessage = new Message(DB_HOST, DB_PORT, DB_DATABASE, DB_USER, DB_PASSWORD);
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
