<?php
require_once 'vendor/autoload.php';
require_once 'libs/functions.php';

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

spl_autoload_register( function ($class) {
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

$kernel = new AppKernel();
//$request = Request::createFromGlobals();
$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$response = $kernel->handle($request);
$response->send();
//$kernel->terminate($request, $response);
