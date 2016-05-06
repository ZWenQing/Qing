<?PHP
define('HOME','home');
require './qingphp/mkfile.php';
include './qingphp/qingphp.php';


$pel = explode('/',$_GET['pel']);
include_once( './../app/'.$pel[0].'/controller/'.$pel[1].'Controller.class.php' );




?>