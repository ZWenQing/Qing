<?php
namespace q;

class controller{
  public $arr = [];
  public function M($modelname){
    
  }
  public function message( $key , $value ){
    $this->arr[$key] = $value;
  }
  
  public function display($filename){
    $filenames = './../app/HOME/view/'.$filename.'.html';
    if( file_exists($filenames) ){
      $this->template(file_get_contents($filenames));
    }else{
      echo "目标文件不存在";
    }
    
    
    
  }
  public function template($content){
    $LeftBound = "<{";
    $RightBound = "}>";
    $Left = preg_quote($LeftBound , '/' );
    $Right = preg_quote($RightBound , '/' );
    $pattern  = array(
      '/'.$Left.'\s+\$(\w*)\s+'.$Right.'/i',
      '/'.$Left.'\s+\$(\w*)(?:\.\$(\w+))?\s+'.$Right.'/i',
      '/'.$Left.'\s+\$(\w*)(?:\:\$(\w+))?\s+'.$Right.'/i',
      '/'.$Left.'\s+volist\s+\$([a-zA-Z][a-zA-Z0-9]*)\s+\$([a-zA-Z][a-zA-z0-9]*)\s+\$([a-zA-Z][a-zA-Z0-9]*)\s+'.$Right.'\s*(.*?)\s*'.$Left.'\/volist'.$Right.'/i',
      '/'.$Left.'\s+for\s+start=\"(\d+)\"\s+end=\"(\d+)\"'.$Right.'\s*(.*?)\s*'.$Left.'\/for'.$Right.'/i'
    );
    $replacement = array(
      '<?php echo (\$${1}) ; ?>',
      '<?php echo (\$${1}["${2}"]) ; ?>',
      '<?php echo (\$${1}->${2}) ; ?>',
      '<?php foreach( $this->arr["${1}"] as \$${2} => \$${3} ){ ?> ${4} <?php }?>',
      '<?php for(\$i = ${1} , \$i < ${2} , \$i++){?> ${3} <?php} ?>'
    );
    extract($this->arr,EXTR_OVERWRITE);
    $result = preg_replace( $pattern , $replacement , $content );
    file_put_contents( './../app/cache/index.html' , $result );
    include_once('./../app/cache/index.html');
  }
}


?>
