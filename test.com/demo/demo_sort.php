<?php
#按照从 小到大 的顺序进行排序。 
$arr = array(1,43,54,62,21,66,32,78,36,76,39);

/**
 * @desc  冒泡排序:从前往后对相邻的两个数依次进行比较和调整，让较大的数往下沉，较小的往上冒。即，每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换。
 * @param array $arr
 * @return $arr
 */
function bubbleSort($arr){
	$length= count($arr);
	#需要冒泡的轮数
	for($i=1; $i<$length; $i++){
		#该层循环用来控制每轮冒出一个数，需要比较的次数
		for($j=0; $j<$length-$i; $j++){
			if ($arr[$j] > $arr[$j+1]) {
				$tmp = $arr[$j+1];
				$arr[$j+1] = $arr[$j];
				$arr[$j] = $tmp;
			}
		}
	}
	return $arr;
}

/**
 * @desc  选择排序:在要排序的一组数中，选出最小的一个数与第一个位置的数交换。然后在剩下的数当中再找最小的与第二个位置的数交换，如此循环到倒数第二个数和最后一个数比较为止。
 * @param array $arr
 * @return $arr
 */
function selectSort($arr){
	$length = count($arr);
	for ($i=1; $i<$length; $i++){
		#先假设第一个即为最小的数
		$p = $i;
		
		for ($j=$i+1; $j<$length; $j++){
			if($arr[$p] > $arr[$j]){
				#比较，发现更小的,记录下最小值的位置
				$p = $j;
			}
		}
		
		#如果发现最小值的位置与当前假设的位置$i不同，则位置互换
		if ($p != $i) {
			$tmp = $arr[$p];
			$arr[$p] = $arr[$i];
			$arr[$i] = $tmp;
		}
	}
	return $arr;
}

/**
 * @desc  插入排序:在要排序的一组数中，假设前面的数已经是排好顺序的，现在要把第n个数插到前面的有序数中，使得这n个数也是排好顺序的。如此反复循环，直到全部排好顺序。
 * @param array $arr
 * @return $arr
 */
function insertSort($arr){
	$length = count($arr);
	 for($i=1; $i<$length;$i++){
	 	$tmp = $arr[$i];
	 	
	 	#内环循环控制，与前边的数据进行比较，并且插入到其中
	 	for($j=$i-1; $j>=0; $j--){
	 		#交换位置
	 		if ($tmp < $arr[$j]) {
	 			#将小的数后移一位，让后插入当前比较的数
	 			$arr[$j+1] = $arr[$j];
	 			$arr[$j] = $tmp;
	 		} else {
	 			#要比较的数据要是没有比前边的数据大的话，就不需要换位置，直接退出这次的循环即可！
	 			break;
	 		}
	 	}
	 }
	 return $arr;
}

/**
 * @desc  快速排序:选择一个基准元素，通常选择第一个元素或者最后一个元素。
 * @	      通过一趟扫描，将待排序列分成两部分，一部分比基准元素小，一部分大于等于基准元素。此时基准元素在其排好序后的正确位置，然后再用同样的方法递归地排序划分的两部分。
 * @param array $arr
 * @return $arr
 */
function quickSort($arr){
	$length = count($arr);
	
	if ($length <= 1) {
		return $arr;
	}
	#将第一个元素作为基准的数
	$base = $arr[0];
	#初始化两个数组
	$left_arr = array();
	$right_arr = array();
	#与基准的数进行比较，然后放到两个数组中、
	for($i=1; $i<$length; $i++){
		if ($arr[$i] > $base) {
			$left_arr[] = $arr[$i];
		} else {
			$right_arr[] = $arr[$i];
		}
	}
	
	#递归调用该函数
	$right_arr = quickSort($right_arr);
	$left_arr  = quickSort($left_arr);
	
	#合并
	$arr = array_merge($right_arr, array($base), $left_arr);
	
	return $arr;
}

$arr = quickSort($arr);
var_dump($arr);

$files = glob('*.php');
var_dump($files);
