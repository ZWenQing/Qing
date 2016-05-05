<?php

if(!file_exists('./../app')){
    mkdir('./../app');
    file_put_contents('./../app/index.html','');
    mkdir('./../app/'.HOME);
    file_put_contents('./../app/'.HOME.'/index.html','');
    mkdir('./../app/'.HOME.'/model');
    file_put_contents('./../app/'.HOME.'/model/index.html','');
    mkdir('./../app/'.HOME.'/controller');
    file_put_contents('./../app/'.HOME.'/controller/index.html','');
    mkdir('./../app/'.HOME.'/view');
    file_put_contents('./../app/'.HOME.'/view/index.html','');
}
?>