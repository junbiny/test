<?php
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("连接失败！"); 

$version = $memcache->getVersion();
echo "Server's version: ".$version."<br/>\n"; 

$tmp_object = new stdClass;
$tmp_object->str_attr = 'test';
$tmp_object->int_attr = 123; 

$memcache->set('key', $tmp_object, false, 10) or die ("未能保存数据在服务器上。");
echo "在缓存中存储数据(数据将在10秒内到期)！<br/>\n"; 

$get_result = $memcache->get('key');
echo "数据来自缓存中:<br/>\n"; 

var_dump($get_result);
