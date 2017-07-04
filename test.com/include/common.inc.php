<?php
#测试机 产品机 配置
if(in_array($_SERVER['SERVER_ADDR'],array('127.0.0.1', '::1')) || !empty($_GET['debug'])){
    ini_set('display_errors', 1);
    error_reporting(E_ALL ^ E_NOTICE);
    $debug = true;
} else {
    $debug = false;
}
define("DEBUG", $debug);

#是否使用缓存
define('CACHE', true);

#时区配置
date_default_timezone_set('Asia/Shanghai');

#根目录
define('ROOT', substr(dirname(__FILE__), 0, -7));

include_once ROOT . 'include/global.func.php'; #常量
include_once ROOT . 'include/config.inc.php'; #配置
include_once ROOT . 'include/db/db.class.php';
include_once 'Smarty-3.1.20/libs/Smarty.class.php';

function __autoload($cls) {
    $clsname = str_replace(array(
            '.',
            '/'
    ), array(
            '',
            ''
    ), $cls);
    $clspath = ROOT . '/model/' . $clsname . '.class.php';

    if (file_exists($clspath)) {
        require_once $clspath;
    }
}

if(!is_dir(CACHE_DIR)){
    mkdir(CACHE_DIR, 0777);
}

if(!is_dir(SMARTY_COMPILE_DIR)){
    mkdir(SMARTY_COMPILE_DIR, 0777);
}

if(!is_dir(SMARTY_CACHE_DIR)){
    mkdir(SMARTY_CACHE_DIR, 0777);
}











