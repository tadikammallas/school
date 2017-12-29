<?php 
    ##################################################
    # author: sandeep/veera
    # DO NOT CHANGE THIS FILE
    ##################################################
    define('DS', DIRECTORY_SEPARATOR);
    define("__BASE_PATH",dirname(__FILE__).DS);
    
    define('__VS_APPS_PATH',__BASE_PATH . 'apps' .DS);
    define('__VS_LIBS_PATH',__BASE_PATH . 'libs' .DS);
    
    include_once('tools/print.php');
    include_once(__VS_LIBS_PATH.'config.php');
    include_once(__VS_LIBS_PATH.'utils.php');
    include_once(__VS_LIBS_PATH.'VS-baseController.php');
   
    
    $URI = explode('/',$_SERVER['REQUEST_URI']);
    $appName = $URI[sizeof($URI) - 2];
    include_once ('apps/'.$appName.'.php');
    
    
    $class = 'VS_'.$URI[sizeof($URI) - 2];
    $action = 'VS_'.$URI[sizeof($URI) - 1]; 
    $controller = new $class();
    $controller->$action();
?>