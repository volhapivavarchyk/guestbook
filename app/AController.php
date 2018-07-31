<?php
namespace Pi\Guesbook\App;

abstract class AController
{
    abstract public function getBody($sort);

    protected function render($file, $params)
    {
        extract($params);
        return include('views/'.$file.'.php');
    }
}
