<?php

//设置路径
defined("Q_PUBLIC") || define("Q_PUBLIC",__DIR__);
defined("Q_APP") || define("Q_APP", __DIR__ ."/app");
defined("Q_QING") || define("Q_QING", __DIR__ ."/qing");
include( Q_QING . "/index.php" );
?>