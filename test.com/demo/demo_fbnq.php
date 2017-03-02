<?php
/*
 * 斐波那契数列
 */

#数组形式返回
function fbnq($i) {
	$data = array();
	$data[0] = 1;
	$data[1] = 1;
	
	for ($n=2; $n < $i; $n++){
		$data[$n] = $data[$n-1] + $data[$n-2];
	}
	
	return $data[$i-1];
}
$data = fbnq(10);


#递归查询
function demo1($n) {
	
	if ($n == 1 || $n == 2) {
		return 1;
	} else {
		return demo1($n-1) + demo1($n-2);
	}
}

#$data = demo1(25);
var_dump($data);