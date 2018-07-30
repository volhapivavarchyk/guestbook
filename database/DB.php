<?php
require_once('pdo.php');

class DB{
  public $db;

  public function __construct($host, $port, $user, $pass, $db){
    $this->db = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$db ,
                        $user, $pass);
    if ($db==NULL)
      exit('Нет соединенения с базой данных');
  }

  public function get_all_records($sql){
    $stmt = $db->query($sql);
    if ($stmt==FALSE)
      exit('По данному запросу нет записей');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)
      $rows[]=$row;
    return $rows;
  }

  public function get_record($sql, $id){
    foreach($db->query($sql) as $row)
      if($row[id]==$id)
        return $row;
  }

  public function add_record($table, $params){
    foreach($params as $key->$param){
      $str_keys.=$key.', ';
      $str_values.=':'.$key.',';
      $params[$key] = ':'.$key;
    }
    $str_keys=substr($str_keys, 0, -1);
    $str_values=substr($str_values, 0, -1);

    $sql = "INSERT INTO ".$table." (".$str_keys.") VALUES (".$str_values.");";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
  }

  public function del_records($table, $fields){
    foreach($fields as $key->field){
      $str_values.=$key.'= :'.$field.' AND ';
      $params[$key] = ':'.$key;
    }
    $str_values=substr($str_keys, 0, -4);

    $sql = "DELETE FROM ".$table." WHERE ".$str_values.";";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
  }
}
?>
