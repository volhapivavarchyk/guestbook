<?php
declare(strict_types=1);

namespace Guestbook\App\Database;

use Guestbook\App\Database\{User, ADBTable as ADBTable};
use PDO;

class Message extends ADBTable
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllItems(string $sort) : array
    {
        $messages = array();
        $sort_elems = explode('_', $sort);

        // формирование sql-запроса
        $sql  = "SELECT messages.*, users.name AS name, users.email AS email
            FROM guestbook.messages
            INNER JOIN guestbook.users
            ON messages.id_user = users.user_id
            ORDER BY ";
        if (!strcmp($sort_elems[0], 'name')) {
          $sql .= " name";
        } elseif (!strcmp($sort_elems[0], 'email')) {
          $sql .= " email";
        } elseif (!strcmp($sort_elems[0], 'date')) {
          $sql .= " date";
        }
        $sql = strcmp($sort_elems[1], 'desc') ? $sql." ASC;" : $sql." DESC;";
        // формирование sql-запроса
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute()) {
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $messages;
        }
        return $messages;
    }

    public function getAllItems25(string $sort) : array
    {
        $messages = $this->getAllItems($sort);
        $i = 0;
        $j = 0;
        $blocksOfMessages = array();
        foreach ($messages as $message) {
            $blocksOfMessages[$i][$j] = $message;
            if ($j == 25) {
                $i += 1;
                $j = 0;
            }
            $j += 1;
        }
        return $blocksOfMessages;
    }

    public function addItem(array $params) : string
    {
        $t_user = new User();
        extract($params);
        $user_id = (int) $t_user->getIdItem(['name' => $name, 'email' => $email]);
        if ($user_id === 0){
            $user_id = (int) $t_user->addItem(['name' => $name, 'email' => $email]);
        }
        $sql = "INSERT INTO guestbook.messages
            (theme, text, pictures, filepath, date, ip, browser, id_user)
            VALUE
            (:theme, :text, :pictures, :filepath, :date, :ip, :browser, :id_user);";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':theme' => strip_tags($theme),
            ':text' => strip_tags($text, '<i><strong><strike><code><a>'),
            ':pictures' => $pictures,
            ':filepath' => $filepath,
            ':date' => $date,
            ':ip' => $ip,
            ':browser' => $browser,
            ':id_user' => $user_id
        ]);
        return $this->db->lastInsertId() ? 'сообщение добавлено' : 'сообщение не добавлено';
    }
}
