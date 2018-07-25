<?php

class IndexController extends AController {
  public $t_message;

  public function __construct(){
      $this->t_message = new Message(DB_HOST, DB_PORT, DB_DATABASE, DB_USER, DB_PASSWORD);
  }

  public function get_body($sort){

    $messages = $this->t_message->getAllItems($sort);
    $this->render('indexView', ['sort'=>$sort,
                                'messages'=>$messages
                               ]);
  }

  public function addMessage($params){
    $messages = $this->t_message->addItem($params);
  }
}
?>
