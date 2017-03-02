<?php
$mem = new Memcache;
$mem->connect("127.0.0.1", 11211) or die('memcache connect failed'); //参数一是本机地址，当然也可是其他机器的地址，参数二是端口号
//保存数据
$mem->set('hello', 'hello world', 0, 60);
$val = $mem->get('hello');
echo $val;
