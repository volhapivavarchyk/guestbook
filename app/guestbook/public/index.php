<?php

use Symfony\Component\HttpFoundation\{Request, Response};
use Piv\Guestbook\App\Kernel;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new Kernel();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
