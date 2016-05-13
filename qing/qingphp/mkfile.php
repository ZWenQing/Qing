<?php
defined("_HOME") or define("_HOME","home");
defined("_WORK") or define("_WORK",_APP."/"._HOME);
defined("_MODEL") or define("_MODEL",_WORK."/model");
defined("_CONTROLLER") or define("CONTROLLER",_WORK."/controller");
defined("_VIEW") or define("_VIEW",_WORK."/view");
if(!file_exists(_PUBLIC.'/app')){
    mkdir(_PUBLIC.'/app');
    file_put_contents(_PUBLIC.'/app/index.html','');
    mkdir(_WORK);
    file_put_contents(_WORK.'/index.html','');
    mkdir(_MODEL);
    file_put_contents(_MODEL.'/index.html','');
    mkdir(_CONTROLLER);
    file_put_contents(_CONTROLLER.'/index.html','');
    $contents = file_get_contents(_QING.'/qingphp/config/indexController.class.php');
    file_put_contents(_CONTROLLER."/IndexController.class.php",$contents);
    mkdir(_VIEW);
    file_put_contents(_VIEW.'/index.html','');
}
?>