<?php

class IndexController extends AController {

  public function __construct(){
  }

  public function get_body($sort){

    $message = new Message(DB_HOST, DB_PORT, DB_DATABASE, DB_USER, DB_PASSWORD);
    $messages = $message->get_all_messages($sort);
    $this->render('indexView', ['sort'=>$sort,
                                'messages'=>$messages
                               ]);
  }
}
?>
