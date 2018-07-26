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

  function resizeImage($filename, ...){
    $width = $width_orig*$percent;
    $height = $height_orig*$percent;
    $image_p = imagecreatetruecolor($width, $height);
    $image = ImageCreateFromPNG($tmp_name);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
    imagepng($image_p,$tmp_name,0);
    imagedestroy($image_p);
  }

  spl_autoload_register('myAutoloader');

  $init = new IndexController();

  if (isset($_GET['sort'])){
    $sort=$_GET['sort'];
  }
  elseif (isset($_POST['send'])) {
    if (!isset($_POST['name']))
      header ("Location:index.php");
    if (!isset($_POST['email']))
      header ("Location:index.php");
    if (!isset($_POST['homepage']))
      $homepage="";
    if (!isset($_POST['text']))
      header("Location:index.php");
    if (!isset($_POST['pictures']))
      $pictures="";
    else {
      $size_pict = getimagesize ($FILE[$_POST['pictures']][name]);
      if ((size_pict[2] == IMG_JPG) or (size_pict[2] == IMG_GIF) or (size_pict[2] == IMG_PNG)
        if (($size_pict[0]>320) or ($size_pict[1]>240)){
          resizeImage($FILE[$_POST['pictures']][name]);
        }
      else {
        $pictures="";
      }
    }
    if (!isset($FILE[$_POST['filepath']][name]))
      $filepath="";
    else {
      $filename = $_FILE[$_POST['filepath']][type];
      if((pathinfo($filename, PATHINFO_EXTENSION) !='txt') or
         ($_FILE[$_POST['filepath']][size]>819200) ){
           store_uploaded_file(...);
           $filepath = "";
         }
    }

    $init->addMessage($_POST);
    $sort = 'date_desc';
  }
  else{
    $sort = 'date_desc';
  }

  echo $init->get_body($sort);

?>
