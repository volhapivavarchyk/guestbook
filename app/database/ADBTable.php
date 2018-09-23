<?php
namespace Guestbook\App\Database;

use PDO;

abstract class ADBTable
{
    public $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host = '.DB_HOST.';port = '.DB_PORT.';dbname = '.DB_DATABASE, DB_USER, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    abstract public function getAllItems($sort);
    abstract public function getIdItem($params);
    abstract public function addItem($params);
}