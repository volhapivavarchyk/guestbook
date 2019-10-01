<?php

use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\EventDispatcher\EventDispatcher;
use Piv\Guestbook\Src\Kernel;

require_once __DIR__ . '/../vendor/autoload.php';

$request = Request::createFromGlobals();

//$dispatcher = new EventDispatcher();
// ... добавить какие-то слушатели событий
//$dispatcher->addSubscriber(new )

//$controllerResolver = new ControllerResolver();
//$argumentResolver = new ArgumentResolver();

//$kernel = new Kernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);

$kernel = new Kernel();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
