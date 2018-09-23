<?php
namespace Guestbook\App\Controllers;

abstract class ABaseController
{
    public $content;
    public $params;

    abstract public function show($request);
}
