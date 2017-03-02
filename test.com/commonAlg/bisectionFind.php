<?php
/*
 * @desc 二分法查找
 */
$arr = array(1,4,2,5,6,7,0,8,3);
 
function find($arr, $start, $end, $key) {  
	sort($arr);  
	$mid = ceil(($start + $end) / 2);  
	
	if ($arr[$mid] == $key) {  
	   return $mid;  
	} elseif ($arr[$mid] > $key) {  
	   return find($arr, $start, $mid - 1, $key);  
	} else {  
	   return find($arr, $mid + 1, $end, $key);  
	}  
}  
echo find($arr, 0, count($arr), 2);  