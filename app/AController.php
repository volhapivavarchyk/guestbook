<?php
abstract class AController{

  abstract public function get_body($sort);

  protected function render($file, $params){
    extract($params);
    return include('views/'.$file.'.php');
  }
}
?>
