<?php
defined("Q_HOME") or define("Q_HOME","home");
defined("Q_WORK") or define("Q_WORK",Q_APP."/".Q_HOME);
defined("Q_MODEL") or define("Q_MODEL",Q_WORK."/model");
defined("Q_CONTROLLER") or define("Q_CONTROLLER",Q_WORK."/controller");
defined("Q_VIEW") or define("Q_VIEW",Q_WORK."/view");
if(!file_exists(Q_PUBLIC.'/app')){
    mkdir(Q_PUBLIC.'/app');
    file_put_contents(Q_PUBLIC.'/app/index.html','');
    mkdir(Q_WORK);
    file_put_contents(Q_WORK.'/index.html','');
    mkdir(Q_MODEL);
    file_put_contents(Q_MODEL.'/index.html','');
    mkdir(Q_CONTROLLER);
    file_put_contents(Q_CONTROLLER.'/index.html','');
    $contents = file_get_contents(Q_QING.'/config/indexController.class.php');
    file_put_contents(Q_CONTROLLER."/indexController.class.php",$contents);
    mkdir(Q_VIEW);
    file_put_contents(Q_VIEW.'/index.html','');
}
?>