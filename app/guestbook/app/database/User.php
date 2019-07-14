<?php
declare(strict_types=1);

namespace Guestbook\App\Database;

use Guestbook\App\Database\ADBTable as ADBTable;
use PDO;
use PDOStatement;

class User extends ADBTable
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIdItem(array $params) : string
    {
        extract($params);
        $sql = "SELECT * FROM guestbook.users WHERE name=:name AND email=:email;";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute(array(':name'=>$name, ':email'=>$email))) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['user_id'];
        } else {
            return 0;
        }
    }

    public function addItem(array $params) : string
    {
        extract($params);
        $sql = "INSERT INTO guestbook.users (name, email) VALUE (:name, :email);";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':name'=>$name, ':email'=>$email]);
        return  $this->db->lastInsertId();
    }
}
