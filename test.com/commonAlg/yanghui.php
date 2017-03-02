<?php
/*
 * @desc 杨辉三角
 */
$a = array();
for ($i = 0; $i < 6; $i++) {
	$a[$i][0] = 1;
	$a[$i][$i] = 1;
}
for ($i = 2; $i < 6; $i++) {
	for ($j = 1; $j < $i; $j++) {
		$a[$i][$j] = $a[$i-1][$j-1] + $a[$i-1][$j];
	}
}
for ($i = 0; $i < 6; $i++) {
	for ($j = 0; $j <= $i; $j++) {
		echo $a[$i][$j].' ';
	}
	echo '<br/>';
}
