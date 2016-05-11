<?php
namespace q;

class model{
  public $table_name = "";
  public $pdo = null;
  public $sql = array();
  public function __construct(){
    $modelname = str_replace("Model","",get_class($this));
    $this->sql["table"] = $modelname;
    $this->db();
    
  }
  public function db(){
    $config = include ("./qingphp/config/config.php");
    if( $config["db_type"] === "mysql" ){
      $connect = "mysql:host=".$config["host"].";dbname=".$config["db_name"];
      $this->pdo = new \PDO($connect,$config["db_user"],$config["db_pwd"]) or die("连接失败");
      $this->pdo->exec("SET CHARACTER SET utf8");
    }
    return $this;
  }
  
  public function add($data){
    $sql = 'INSERT INTO '.$this->sql["table"]." VALUES ? ";
    $this->pdo->prepare($sql);
    $this->execute($data);
    $res = $this->pdo->fetchAll();
    var_dump();
  }
}

?>