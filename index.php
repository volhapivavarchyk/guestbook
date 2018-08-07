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
var_dump($files);
//$secret = "6LfK42cUAAAAAEm7_FF32qRlCijXs1kkyqAEYSYb";

if (isset($get['sort'])) {
    $sort = $get['sort'];
} elseif (isset($post['send'])) {
    $post['ip']  = $server['REMOTE_ADDR'];
    $post['browser'] = $server['HTTP_USER_AGENT'];
    $post['date'] = date("Y-m-d H:i:s");
    //$post['pictures'] = resizeImg ($post['pictures']);
    $fileTxt = $files['filepath'];
    var_dump($fileTxt->getClientFilename());
    $fileTxt->moveTo("/upload/".$fileTxt->getClientFilename());
    if (is_uploaded_file($fileTxt->getClientFilename())){
      echo '11';
    } else {
      echo '22';
    }
    $init->addMessage($post);
    $sort = 'date_desc';
} else {
    $sort = 'date_desc';
}

$init->getBody($sort);
