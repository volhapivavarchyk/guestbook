<?php
namespace Guestbook\App\Database;

use PDO;
use PDOException;

abstract class ADBTable
{
    public $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host = '.DB_HOST.';port = '.DB_PORT.';dbname = '.DB_DATABASE, DB_USER, DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "Error!: ".$e->getMessage(). "</br>";
        }
    }

    abstract public function addItem($params);
}
