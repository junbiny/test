<?php

$data = [];
$info = [1,2,3,4,5];
foreach ($info as $key => $value) {
	$data[1] .= sprintf("这是第%d个。", $value);
}
var_dump($data);
echo 234;
var_dump(date('W'));
