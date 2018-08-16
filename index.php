<?php
require_once 'vendor/autoload.php';
require_once 'libs/functions.php';

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
$secret = "6LfK42cUAAAAAEm7_FF32qRlCijXs1kkyqAEYSYb";
if (isset($get['sort'])) {
    $sort = $get['sort'];
} elseif (isset($post['send'])) {
    $post['ip']  = $server['REMOTE_ADDR'];
    $post['browser'] = $server['HTTP_USER_AGENT'];
    $post['date'] = date("Y-m-d H:i:s");
    // обработка текста сообщения
    $post['text'] = changeTags($post['text']);
    // обработка изображения
    if ($files['pictures']->getClientFilename() != ''){
        $fileImg = $files['pictures'];
        $filename = "upload/temp/".$fileImg->getClientFilename();
        $fileImg->moveTo($filename);
        resizeAndMoveImage($fileImg, $filename, "upload/img/", 320, 240);
        resizeAndMoveImage($fileImg, $filename, "upload/img/small/", 60, 50);
        unlink($filename);
        $post['pictures'] = $fileImg->getClientFilename();
    } else {
        $post['pictures'] = '';
    }
    // обработка текстового файла
    if ($files['filepath']->getClientFilename() != ''){
        $fileTxt = $files['filepath'];
        $filename = "upload/txt/".$fileTxt->getClientFilename();
        $fileTxt->moveTo($filename);
        $post['filepath'] = $filename;
    } else {
        $post['filepath'] = '';
    }
    // добавление записи
    $init->addMessage($post);
    $sort = 'date_desc';
} else {
    $sort = 'date_desc';
}

$init->getBody($sort);
