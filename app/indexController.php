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
        $i = 0;
        $j = 0;
        foreach ($messages as $message) {
            $blocksOfMessages[$i][$j] = $message;
            if ($j == 25) {
                $i += 1;
                $j = 0;
            }
            $j += 1;
        }
        $this->render('indexView', [
            'sort' => $sort,
            'blocksOfMessages' => $blocksOfMessages
        ]);
    }

    public function addMessage($params)
    {
        $messages = $this->tMessage->addItem($params);
    }
}
