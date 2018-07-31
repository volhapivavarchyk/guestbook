<?php
namespace Pi\Guestbook\Database;

use PDO;

abstract class ADBTable
{
    public $db;

    public function __construct()
    {
        $params = include('config/db.php');
        $this->db = new PDO('mysql:host = '.DB_HOST.';port = '.DB_PORT.';dbname = '.DB_DATABASE, DB_USER, DB_PASSWORD);
    }

    abstract public function getAllItems($sort);
    abstract public function getIdItem($params);
    abstract public function addItem($params);
}
