<?php
namespace Pi\Guestbook\Database;

use Pi\Guestbook\Database\ADBTable as ADBTable;

class User extends ADBTable
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllItems($sort)
    {
    }

    public function getIdItem($params)
    {
        extract($params);
        $sql = "SELECT * FROM users WHERE name=:name AND email=:email;";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute(array(':name'=>$name, ':email'=>$email))) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['user_id'];
        } else {
            return false;
        }
    }

    public function addItem($params)
    {
        extract($params);
        $sql = "INSERT INTO users (name, email) VALUE (:name, :email);";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':name'=>$name, ':email'=>$email));
        return  $this->db->lastInsertId();
    }
}
