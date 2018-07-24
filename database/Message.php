<?php

class Message extends ADBTable {

  public function __construct($host, $port, $db, $user, $pass){
    parent::__construct($host, $port, $db, $user, $pass);
  }

  public function getAllItems($sort){
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

  public function getIdItem($params) {
  }

  public function addItem($params){

    $t_user = new User(DB_HOST, DB_PORT, DB_DATABASE, DB_USER, DB_PASSWORD);
    extract($params);
    $user_id = $t_user->getIdItem(['name'=>$name, 'email'=>$email]);
    if($user_id==NULL)
      $user_id=$t_user->addItem(['name'=>$name, 'email'=>$email]);

    $sql = "INSERT INTO
           messages (theme, text, pictures, filepath, date, ip, browser, user_id)
           VALUE
           (:theme, :text, :pictures, :filepath, :date, :ip, :browser, :user_id);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
                    ':theme'=>$theme,
                    ':text'=>$text,
                    ':pictures'=>$pictures,
                    ':filepath'=>$filepath,
                    ':date'=>$date,
                    ':ip'=>$ip,
                    ':browser'=>$browser,
                    ':user_id'=>$user_id
    ));
  }
}
?>
