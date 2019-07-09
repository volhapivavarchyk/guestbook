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
            $dns = $_ENV['DB_DRIVER'].":host=".$_ENV['DB_HOST'].";port=".$_ENV['DB_PORT'].";dbname=".$_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];
            $this->db = new PDO($dns, $user, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "Error!: ".$e->getMessage(). "</br>";
        }
    }

    abstract public function addItem($params);
}
