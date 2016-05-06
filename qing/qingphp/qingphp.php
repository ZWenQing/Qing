<?php
namespace q;

class controller{
  public $arr = [];
  public function M($modelname){
    
  }
  public function msseg( $key , $value ){
      $arr1 = [$key=>$value];
      $this->arr = array_merge($this->arr , $arr1);
  }
  
  public function display($filename){
    $filenames = './../app/HOME/view/'.$filename.'.html';
    $get_contents = file_get_contents($filenames);
    echo $get_contents;
    }
}


?>
