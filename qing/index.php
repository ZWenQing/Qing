<?PHP
define('HOME','home');
require './qingphp/mkfile.php';
include './qingphp/qingphp.php';
include './qingphp/model.class.php';
use q\model;
class models extends model{
  
}
$model = new models();
$pel = explode('/',$_GET['pel']);
include_once( './../app/'.$pel[0].'/controller/'.$pel[1].'Controller.class.php' );
$controller = '\home\index\\'.$pel[1].'Controller';
$cont = new $controller;
$cont->indexAction();

?>