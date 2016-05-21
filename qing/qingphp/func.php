<?php
/*
 * 一些功能函数
 * */
//D方法
function D( $name ){
    $s = debug_backtrace();
    $l = explode('\\',$s[1]['class']);
    $modelname = $l[0]."\\Model\\".ucfirst(strtolower($name)).'Model';
    return new $modelname;
}
function M( $name ){
    $s = 'q\\Model';
    return new $s( $name );
}
?>