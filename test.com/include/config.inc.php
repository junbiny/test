<?php
#可写文件目录
define('CACHE_DIR', $_SERVER['SINASRV_CACHE_DIR'] . 'TEMPLATE/'); //缓存目录

#smarty
define('SMARTY_COMPILE_DIR', CACHE_DIR . "templates_c/"); //指定模板目录
define('SMARTY_CACHE_DIR', CACHE_DIR . "templates_cache/"); //指定缓存目录，这个目录里面放着最终显示的网站php 文件

if(DEBUG) {
    #测试机数据库配置
    $GLOBALS['db_conf'] = array(
        0 => array('user' => "root", 'password' => "root", 'host' => "127.0.0.1", 'port' => "3306", 'database' => ""),
        1 => array('user' => "root", 'password' => "root", 'host' => "127.0.0.1", 'port' => "3306", 'database' => "")
    );
} else {
    #产品机数据库配置
    #$GLOBALS['db_conf'] = array(
    #    0 => array('user' => $_SERVER['SINASRV_DB_USER'], 'password' => $_SERVER['SINASRV_DB_PASS'], 'host' => $_SERVER['SINASRV_DB_HOST'], 'port' => $_SERVER['SINASRV_DB_PORT'], 'database' => $_SERVER['SINASRV_DB_NAME']),
    #    1 => array('user' => $_SERVER['SINASRV_DB_USER_R'], 'password' => $_SERVER['SINASRV_DB_PASS_R'], 'host' => $_SERVER['SINASRV_DB_HOST_R'], 'port' => $_SERVER['SINASRV_DB_PORT_R'], 'database' => $_SERVER['SINASRV_DB_NAME_R'])
    #);
}