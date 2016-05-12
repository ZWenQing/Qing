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
  
  public function data($data){
    $this->sql["data"] = $data;
    return $this;
  }
  
  public function add(){
      $keys = array_keys($this->sql["data"]);
      $values = array_values($this->sql["data"]);
      $keyname = null;
      $valuename = null;
      for( $i = 0 ; $i < count($keys); $i++ ){
        if( $i === 0 ){
          $keyname .= $keys[$i];
          $valuename .= "'".$values[$i]."'"; 
        }else{
          $keyname .= ",".$keys[$i];
          $valuename .= ",'".$values[$i]."'"; 
        }
      }
      $sql = "INSERT INTO ".$this->sql["table"]."(".$keyname.") VALUES (".$valuename.")";
      //print_r($sql);die;
      //$requre = $this->pdo->prepare($sql);
      //$res = $requre->execute();
      $res = $this->pdo->query($sql);
      var_dump($res);die();
  }
  public function clos(){
    $this->pdo = null;
  }
}

?>