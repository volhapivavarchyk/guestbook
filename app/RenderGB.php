<?php

class IndexController extends AController{
  public function __construct(){
    //echo __CLASS__;
  }

  public function get_body(){
    $db = new Model(HOST, USER, PASSWORD, DB);
    $text = $db->get_all("SELECT * FROM articles");
    $this->render('indexView', ['title'=>'Index page',
                                'text'=>$text
                               ]);
  }
}
?>
