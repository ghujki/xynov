<?php
$dis=Yaf_Dispatcher::getInstance();
Yaf_Registry::set("Module_path",__DIR__);
//Initialize Routes for Admin module
$routes = new Yaf_Config_Ini(__DIR__ . "/config" . "/routes.ini");
$dis->getRouter()->addConfig($routes->spider);
