<?php
namespace Pi\Guestbook\App;

abstract class AController
{
    abstract public function setMessage($post);
    abstract public function getListMessages($sort, $added);

    protected function render($file, $params)
    {
        extract($params);
        return include('views/'.$file.'.php');
    }
}
