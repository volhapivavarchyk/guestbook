<?php
require 'vendor/autoload.php';

use Pi\Guestbook\App\IndexController;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

spl_autoload_register(function ($class) {
    $prefix_app = 'Pi\\Guestbook\\App\\';
    $prefix_db = 'Pi\\Guestbook\\Database\\';
    $len = strlen($prefix_app);
    if (strncmp($class, $prefix_app, $len-1) === 0) {
        $relative_class = substr($class, strlen($prefix_app));
        require_once 'app/'.$relative_class.'.php';
    } elseif (strncmp($class, $prefix_db, strlen($prefix_db)) === 0) {
        $relative_class = substr($class, strlen($prefix_db));
        require_once 'database/'.$relative_class.'.php';
    } else {
        return '';
    }
});

$init = new IndexController();

$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$get = $request->getQueryParams();
$post = $request->getParsedBody();
$server = $request->getServerParams();
$files = $request->getUploadedFiles();
//$secret = "6LfK42cUAAAAAEm7_FF32qRlCijXs1kkyqAEYSYb";
if (isset($get['sort'])) {
    $sort = $get['sort'];
} elseif (isset($post['send'])) {
    $post['ip']  = $server['REMOTE_ADDR'];
    $post['browser'] = $server['HTTP_USER_AGENT'];
    $post['date'] = date("Y-m-d H:i:s");
    // обработка изображения
    $fileImg = $files['pictures'];
    $filename = "upload/img/".$fileImg->getClientFilename();
    $fileImg->moveTo($filename);

    list($width, $height, $type) = getimagesize($filename);
    $new_width = 320;
    $new_height = 240;
    $size = getimagesize($filename);
    if (($width > $new_width) || ($height > $new_height)) {
      $w_index = $new_width / $width;
      $h_index = $new_height / $height;
      $new_width = $w_index>$h_index ? $width*$h_index : $width*$w_index;
      $new_height = $w_index>$h_index ? $height*$h_index : $height*$w_index;
    }
    $new_image = imagecreatetruecolor($new_width, $new_height);
    switch ($type) {
      case 3:
          $image = imagecreatefrompng($filename);
          break;
      case 2:
          $image = imagecreatefromjpg($filename);
          break;
      case 1:
          $image = imagecreatefromgif($filename);
          break;
      default:
          // 'error';
    }
    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    switch ($type) {
      case 3:
          //header("Content-type: image/png");
          imagepng($new_image, "upload/img/small/".$fileImg->getClientFilename());
          break;
      case 2:
          //header("Content-type: image/jpeg");
          imagejpeg($new_image, "upload/img/small/".$fileImg->getClientFilename());
          break;
      case 1:
          //header("Content-type: image/gif");
          imagegif($new_image, "upload/img/small/".$fileImg->getClientFilename());
          break;
      default:
          // error;
    }
    $post['pictures'] = $fileImg->getClientFilename();
    //unlink($filename);
    // обработка текстового файла
    $fileTxt = $files['filepath'];
    $filename = "upload/txt/".$fileTxt->getClientFilename();
    $fileTxt->moveTo($filename);
    $post['filepath'] = $filename;
    $init->addMessage($post);
    $sort = 'date_desc';
} else {
    $sort = 'date_desc';
}

$init->getBody($sort);
