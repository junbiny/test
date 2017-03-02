<?php
/**
 * @desc 合并多个数组，不用array_merge()
 * 思路：遍历每个数组，重新组成一个新数组。
 */

function mergeArr($a, $b){
	$re = array();
	foreach ($a as $val){
		$re[] = $val;
	}
	foreach ($b as $val){
		$re[] = $val;
	}
	
	return $re;
}

$a = array(1,2,4,5,'s');
$b = array(2,5,7,'c','d');
var_dump(mergeArr($a, $b));