<?php
/*
 * 一些功能函数
 * */
//D方法
function D( $name ){
    $s = __FUNCTION__;
    $l = explode('\\',$s);
    var_dump($s);die;
    $modelname = $l[0]."\\Model\\".$name;
    return new $modelname;
}
?>