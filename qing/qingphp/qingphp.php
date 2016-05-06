<?php
namespace q\controller;

class controller{
  public function M($modelname){
    
  }
  
  
  public function display($filename){
    $filenames = './../app/HOME/view/'.$filename.'.html';
    $get_contents = file_get_contents($filenames);
    echo $get_contents;
    }
}


?>
