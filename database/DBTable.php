<?php
class DBTable {

  public $db;

  public function __construct($host, $port,  $db, $user, $pass){
    $this->db = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$db, $user, $pass);
    //echo 'mysql:host='.$host.';port='.$port.'dbname='.$db.$user.$pass;
    if ($db==NULL)
      exit('Нет соединенения с базой данных');
  }

}
?>
