<?php
/**
 * @desc 牛年求牛：有一母牛，到4岁可生育，每年一头，所生均是一样的母牛，到15岁绝育，不再能生，20岁死亡，问n年后有多少头牛
 */

function seekCow($n){
	#$num 牛头数， $n 年
	static $num = 1;
	
	for ($i=1; $i<=$n; $i++){
		#在可生育的年龄内加1，并递归调用该函数
		if ($i >= 4 && $i < 15) {
			$num++;
			seekCow($n-$i);
		}
		
		#死亡即减
		if ($i == 20) {
			$num--;
		}
	}
	return $num;
}

$n = 20;
$sum_cow = seekCow($n);
echo $n.'年后，有'.$sum_cow.'头牛';