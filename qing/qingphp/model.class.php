<?php
namespace q;

class model{
  public function __construct(){
    $modelname = str_replace("Model","",get_class($this));
    $this->db($modelname);
    
  }
  public function db($modelname){
    $config = include ("./qingphp/config/config.php");
    if( $config["db_type"] === "mysql" ){
      $connect = "mysql:host=".$config["host"].";dbname=".$config["db_name"];
      // var_dump($connect);
      $pdo = new \PDO($connect,$config["db_user"],$config["db_pwd"]) or die("未连接");
      
    }
  }
}

?>