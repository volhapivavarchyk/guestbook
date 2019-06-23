<?php
namespace Guestbook\App\Controllers;

use Zend\Diactoros\ServerRequest;

abstract class ABaseController
{
    public $content;
    public $params;

    abstract public function show($request);
}
