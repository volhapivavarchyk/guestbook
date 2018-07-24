<?php
class User extends ADBTable {

  public function __construct($host, $port, $db, $user, $pass){
    parent::__construct($host, $port, $db, $user, $pass);
  }

  public function getAllItems($sort) {
  }

  public function getIdItem($params) {
    extract($params);
    $str = "SELECT user_id
            FROM users
            WHERE name=".$name." AND email=".$email.";";
    $stmt=$this->db->query($str);
    return $user_id=$stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function addItem($params) {
    extract($params);
    $sql = "INSERT INTO user (name, email)
            VALUE (:name, :email);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':name'=>$name,
                          ':email'=>$email
                          ));
  }
}
?>
