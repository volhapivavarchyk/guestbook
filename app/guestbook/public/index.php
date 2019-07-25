<?php

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Piv\Guestbook\App\AppKernel;
use Piv\Guestbook\App\Http\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new AppKernel();
$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$response = $kernel->handle($request);
$response->send();
