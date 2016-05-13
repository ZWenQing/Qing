<?PHP


$dirs = _QING."/qingphp";
$s = dir($dirs);
while( $filename = $s->read() ){
  if( $filename == "." || $filename == ".." || is_dir($dirs."/".$filename)){
    continue;
  }
  include_once $dirs.'/'.$filename;
}
$pel = explode('/',$_GET['pel']);
include_once( './app/'.$pel[0].'/controller/'.$pel[1].'Controller.class.php' );
$controller = '\\home\\index\\'.$pel[1].'Controller';
$controllers = new $controller;
$controllers->indexAction();
?>