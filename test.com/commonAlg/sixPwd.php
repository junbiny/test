<?php
/*
 * @desc 用户密码六位数,不能大于六位而不能小于六数,数字值正则为[0-9],请用PHP写出有几种可能性,并做暴力破解;
 */

function dePassword($pwd) {
	$tmp = array('000000', '555555', '999999');
	for ($i = 0; $i < 3; $i++) {
		if ($pwd == $tmp[$i]) return $tmp[$i];
	}
	return $pwd < $tmp[1] ? getPwd(0, $pwd, $tmp) : getPwd(1, $pwd, $tmp);
}

function getPwd($i, $pwd, $tmp) {
	$half = ceil(($tmp[$i] + $tmp[$i + 1]) / 2);
	if ($half == $pwd) {
		return $half;
	} elseif ($half > $pwd) {
		return returnI($pwd, $tmp[$i], $half);
	} else {
		return returnI($pwd, $half, $tmp[$i + 1]);
	}
}

function returnI($pwd, $start, $end){
	for ($i = $start + 1; $i < $end; $i++) {
		if ($i == $pwd) return $i;
	}
}

$pwd = '000089';
printf('%06s', dePassword($pwd));