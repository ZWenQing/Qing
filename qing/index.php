<?PHP


$dirs = Q_QING."/qingphp";
$s = dir($dirs);
while( $filename = $s->read() ){
  if( $filename == "." || $filename == ".." || is_dir($dirs."/".$filename)){
    continue;
  }
  include_once $dirs.'/'.$filename;
}
//url
if( empty($_GET['pel']) ){
    $pel[0] = "home";
    $pel[1] = "index";
    $pel[2] = "index";
}else{
    $pel = explode('/',$_GET['pel']);
}
include_once( './app/'.$pel[0].'/controller/'.$pel[1].'Controller.class.php' );
$controller = '\\home\\index\\'.$pel[1].'Controller';
$controllers = new $controller;
$fun = $pel[2]."Action";
$controllers->$fun();
?>