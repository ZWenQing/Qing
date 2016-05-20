<?PHP


$dirs = Q_QING."/qingphp";
function load( $dirs ){
    $s = dir($dirs);
    while( $filename = $s->read() ){
      if( $filename == "." || $filename == ".." ){
        continue;
      }
      if( is_dir("{$dirs}/{$filename}") ){
        load("{$dirs}/{$filename}");
      }
      strrchr($filename , '.') === '.php' and include_once("{$dirs}/{$filename}");
    }
    $s->close();
}
load($dirs);
load(Q_APP);
//url
if( empty($_GET['pel']) ){
    $pel[0] = "home";
    $pel[1] = "index";
    $pel[2] = "index";
}else{
    $pel = explode('/',$_GET['pel']);
}
$controller = '\\'.ucfirst(strtolower($pel[0])).'\\'.ucfirst(strtolower($pel[1])).'\\'.ucfirst(strtolower($pel[1])).'Controller';
$controllers = new $controller;
$fun = $pel[2]."Action";
$controllers->$fun();
?>