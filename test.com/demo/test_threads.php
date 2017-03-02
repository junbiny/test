<?php
$array = array('a'=>'Dog', 'b'=>'Voule', 'c'=>'Cat', 'd'=>'Hourse');
sort($array);
var_dump($array);
$temstr = implode('', $array);
$temstr = sha1($temstr);
var_dump($temstr);

#打开缓存
ob_start();
echo "Hello\n";