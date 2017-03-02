<?php
/*****************************
 *数据库连接
*****************************/

try {
	$db = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec('set names utf8');
	#$db = null;  //关闭数据库
} catch (PDOException $e) {
	exit('数据库连接失败，错误信息：' . $e->getMessage());
}
