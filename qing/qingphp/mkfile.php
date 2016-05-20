<?php

defined("Q_HOME") or define("Q_HOME","home");
defined("Q_WORK") or define("Q_WORK",Q_APP."/".Q_HOME);
defined("Q_MODEL") or define("Q_MODEL",Q_WORK."/model");
defined("Q_CONTROLLER") or define("Q_CONTROLLER",Q_WORK."/controller");
defined("Q_VIEW") or define("Q_VIEW",Q_WORK."/view");
/*
if(!file_exists(Q_PUBLIC.'/app')){
    mkdir(Q_PUBLIC.'/app');
    file_put_contents(Q_PUBLIC.'/app/index.html','');
    mkdir(Q_WORK);
    file_put_contents(Q_WORK.'/index.html','');
    mkdir(Q_MODEL);
    file_put_contents(Q_MODEL.'/index.html','');
    mkdir(Q_CONTROLLER);
    file_put_contents(Q_CONTROLLER.'/index.html','');
    $contents = file_get_contents(Q_QING.'/config/IndexController.class.php');
    file_put_contents(Q_CONTROLLER."/IndexController.class.php",$contents);
    mkdir(Q_VIEW);
    file_put_contents(Q_VIEW.'/index.html','');
}*/
/*
 *重写
 *复制文件夹
 *@$copyfile   需要copy的文件夹路径
 *@$file   拷贝的目的地路径
 */

function copydir( $copyfile , $file ){
  //var_dump(file_exists($file));die;
  if( is_file($copyfile) ){
    return copy( $copyfile , $file );
  }elseif( !file_exists($file) ){
    mkdir($file);
    copydir( $copyfile , $file );
  }elseif( is_dir($copyfile) ){
    $dir = dir( $copyfile );
    while( $filename = $dir->read() ){
      if( $filename !== "." && $filename !== ".."  ){
        if( is_dir( "{$copyfile}/{$filename}" ) ){
          file_exists( "{$file}/{$filename}" ) or mkdir( "{$file}/{$filename}" );
          copydir( "{$copyfile}/{$filename}" , "{$file}/{$filename}" );
        }
        copydir( "{$copyfile}/{$filename}" , "{$file}/{$filename}" );
      }
    }
  }else{
    return '文件路径有错';
  }
}
if( false ){
  copydir( Q_QING.'/app' , Q_PUBLIC.'/app' );
}



?>