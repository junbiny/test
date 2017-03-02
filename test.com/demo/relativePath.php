<?php
/*
 * A相对于B的路径
*/
function getRelativePath($path1, $path2) {
	$relativePath = "";
	$path_arr1 = explode('/', ($path1));
	$path_arr2 = explode('/', ($path2));

	$len = count($path_arr2) > count($path_arr1) ? count($path_arr1) : count($path_arr2);

	//判断第n个元素下文件目录之前相同
	$n = 0;
	do {
		if ($n >= $len || $path_arr1[$n] != $path_arr2[$n]) {
			break;
		}
	}while (++$n);
	
	$relativePath .= str_repeat('../', count($path_arr2)-$n);
	$relativePath .= implode('/', array_splice($path_arr1, $n));
	return $relativePath;
}

$path1 = '/home/web/lib/img/cache.php';
$path2 = '/home/web/libc/img/show.php';
$val = getRelativePath($path1, $path2);
var_dump($val);