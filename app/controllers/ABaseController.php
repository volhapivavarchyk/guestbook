<?php
namespace Guestbook\App\Controllers;

use Zend\Diactoros\ServerRequest;

abstract class ABaseController
{
    abstract public function show($request);
}
