<?php
  include 'config.php';
  header("Content-Type:text/html; charset = 'utf8'");

  function myAutoloader($nameClass){
    if(file_exists('app/'.$nameClass.'.php')){
      require_once 'app/'.$nameClass.'.php';
    }
    else{
      require_once 'database/'.$nameClass.'.php';
    }
  }

  spl_autoload_register('myAutoloader');

  $init = new IndexController();

  if (isset($_GET['sort'])){
    $sort=$_GET['sort'];
    echo $init->get_body($_GET['sort']);
  }
  elseif (isset($_POST['name'])) {
    // code...
  }
  else{
    $sort = 'date_desc';
    echo $sort.'111';
    echo $init->get_body($sort);
  }

?>
