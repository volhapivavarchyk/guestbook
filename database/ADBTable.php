<?php
abstract class ADBTable
{
    public $db;

    public function __construct($host, $port,  $db, $user, $pass)
    {
        $this->db = new PDO('mysql:host = '.$host.';port = '.$port.';dbname = '.$db, $user, $pass);
    }

    abstract public function getAllItems($sort);
    abstract public function getIdItem($params);
    abstract public function addItem($params);
}
