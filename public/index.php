<?php
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Guestbook\App\AppKernel;
use Guestbook\App\Http\Response;

require_once '../config/config.php';
require_once '../vendor/autoload.php';

spl_autoload_register( function ($class) {
    $prefix_app = 'Guestbook\\App\\';
    if (strncmp($class, $prefix_app, strlen($prefix_app)-1) === 0) {
        $separatorPosition = strpos($class, '\\');
        $class = substr($class, $separatorPosition+1, strlen($class));
        $logicalPath = strtr($class, '\\', '/') . '.php';
        require_once '../'.$logicalPath;
    }
});

$kernel = new AppKernel();
$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$response = $kernel->handle($request);
$response->send();
