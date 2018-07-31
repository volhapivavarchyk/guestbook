<?php
namespace Pi\Guestbook\Database;

use Pi\Guestbook\Database\ADBTable as ADBTable;

class Message extends ADBTable
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllItems($sort)
    {
        $messages = array();
        $sort_elems = explode('_', $sort);
        $sql  = "SELECT messages.*, users.name, users.email
            FROM messages
            INNER JOIN users
            ON messages.id_user = users.user_id
            ORDER BY :what :how ; ";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([':what' => $sort_elems[0], ':how' => $sort_elems[1]])) {
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $messages;
        }
        return $messages;
    }

    public function getIdItem($params)
    {

    }

    public function addItem($params)
    {
        $t_user = new User(DB_HOST, DB_PORT, DB_DATABASE, DB_USER, DB_PASSWORD);
        extract($params);
        $user_id = (int)$t_user->getIdItem(['name' => $name, 'email' => $email]);
        if ($user_id == false){
            $user_id = (int)$t_user->addItem(['name' => $name, 'email' => $email]);
        }
        $sql = "INSERT INTO messages
            (theme, text, pictures, filepath, date, ip, browser, id_user)
            VALUE
            (:theme, :text, :pictures, :filepath, :date, :ip, :browser, :id_user);";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':theme' => $theme,
            ':text' => $text,
            ':pictures' => $pictures,
            ':filepath' => $filepath,
            ':date' => $date,
            ':ip' => $ip,
            ':browser' => $browser,
            ':id_user' => $user_id
        ]);
    }
}
