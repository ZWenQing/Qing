<?PHP
define('HOME','home');
require './qingphp/mkfile.php';
include './qingphp/qingphp.php';


//$pel = explode('/',$_GET['pel']);
//include_once( './../app/'.$pel[0].'/controller/'.$pel[1].'Controller.class.php' );
$cont = new \q\controller();
$cont->message('name','我正在使用模板。。');
$cont->message('ccc',array(1,2,4));
$cont->display('index');


?>