<?php
namespace q;

class Model{
  public $table_name = "";
  public $pdo = null;
  public $sql = array();
  public function __construct(){
    $modelname = str_replace(["Model","Home","\\"],"",get_class($this));
    $this->sql["table"] = $modelname;
    $this->db();
    
  }
  public function db(){
    $config = include ("./qing/config/config.php");
    if( $config["db_type"] === "mysql" ){
      $connect = "mysql:host=".$config["host"].";dbname=".$config["db_name"];
      $this->pdo = new \PDO($connect,$config["db_user"],$config["db_pwd"]) or die("连接失败");
      $this->pdo->exec("SET CHARACTER SET utf8");
    }
    return $this;
  }
  
  public function data($data){
    $this->sql["add"] = $data;
    return $this;
  }
  
  public function add(){
    $keys = array_keys($this->sql["add"]);
    $values = array_values($this->sql["add"]);
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
    $requre = $this->pdo->prepare($sql);
    $res = $requre->execute();
    //$res = $this->pdo->query($sql);
    $this->clos();
    return $res;
  }
  
  public function where($data){
    $this->sql["where"] = $data;
    return $this;
  }
  
  public function select(){
    if( !empty($this->sql["where"]) ){
      $keys = array_keys($this->sql["where"]);
      $keyname = null;
      for( $i = 0 ; $i < count($keys); $i++ ){
        $keyname .= $keys[$i]."=:".$keys[$i];
      }
      $sql = "select * from ".$this->sql["table"]." where ".$keyname;
      $pdo = $this->pdo->prepare($sql);
      $arr = array();
      foreach( $this->sql["where"] as $key => $value ){
        $arr[ ":".$key ] = "qing";
      }
      var_dump($arr);
      $pdo->execute($arr);
    }else{
      $sql = "select * from ".$this->sql["table"];
      $pdo = $this->pdo->prepare($sql);
      $pdo->execute();
    }
    $res = $pdo->fetchAll();
    $this->clos();
    return $res;
  }
  
  public function save($data = null){
    if( !empty($this->sql["where"]) ){
      $keys = array_keys($this->sql["where"]);
      $keysname = null;
      for( $i = 0 ; $i < count($keys); $i++ ){
        $keysname .= $keys[$i]."='".$this->sql[ "where" ][ $keys[$i] ]."'";
      }
    }
    if( !empty($data) ){
      $datas = array_keys($data);
      $setsql = null;
      for( $j = 0 ; $j < count( $datas ); $j++  ){
        $setsql .= $datas[$j]."='".$data[$datas[$j]]."'";
      }
    }
    $sql = "update ".$this->sql["table"]." set ".$setsql." where ".$keysname;
    $pdo = $this->pdo->prepare($sql);
    $pdo->execute() or var_dump($pdo->errorInfo());
    $this->clos();
    return $pdo;
  }
  
  public function deletes(){
    if( !empty($this->sql["where"]) ){
      $keys = array_keys($this->sql["where"]);
      $keysname = null;
      for( $i = 0 ; $i < count($keys); $i++ ){
        $keysname .= $keys[$i]."='".$this->sql[ "where" ][ $keys[$i] ]."'";
      }
    }
    $sql = "delete from ".$this->sql["table"]." where ".$keysname;
    $pdo = $this->pdo->prepare($sql);
    $res = $pdo->execute();
    $res or var_dump($pdo->errorInfo());
    $pdo->fetchAll();
    $this->clos();
    return $pdo;
  }
  
  public function clos(){
    $this->pdo = null;
  }
}


?>