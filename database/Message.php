<?php

class Message extends DBTable {

  public function __construct($host, $port, $db, $user, $pass){
    parent::__construct($host, $port, $db, $user, $pass);
  }

  public function get_all_messages($sort){
    $messages=array();
    $sort_elems = explode('_', $sort);
    $str  ="SELECT messages.*, users.name, users.email
            FROM messages INNER JOIN users
            ON messages.id_user = users.user_id
            ORDER BY ". $sort_elems[0]." ".$sort_elems[1].";";
    $stmt = $this->db->query($str);
    if ($stmt==FALSE){
      echo 'В базе данных нет сообщений';
      return $messages;
    }
    while($message = $stmt->fetch(PDO::FETCH_ASSOC))
      $messages[]=$message;
    return $messages;
  }

}
?>
