<?php
/**
 * @desc 把数字1-1亿换成汉字表述，如：123->一百二十三
 */
function intToCnstr($intval){
	$cnNum  = array('零', '一', '二', '三', '四', '五', '六', '七', '八','九');
	$cnUnit = array('', '十', '百', '千', '万', '亿');
	
	$reCnstr = '';
	$intval = intval($intval);
	
	if ($intval >= 0 && $intval < 10) {
		$reCnstr .= $cnNum[$intval];
	} elseif ($intval == 100000000){
		$reCnstr .= $cnNum[1].$cnUnit[5];
	} elseif ($intval > 100000000){
		$reCnstr .= '数据超过一亿！';
	} else {
		$str = strval($intval);
		$len = strlen($intval);
		
		for ($i=0; $i<$len; $i++) {
			if (intval($str{$i}) != 0) {
				#第一个非零字符
				$reCnstr .= $cnNum[intval($str{$i})];
				$j = $len - $i - 1;
				if ($j < 5) {
					$reCnstr .= $cnUnit[$j];
				} elseif ($j >= 5 && $j < 8) {
					$reCnstr .= $cnUnit[$j-4];
				}
			} else {
				#零
				if ($i > 0 && $str{$i} != $str{$i-1}) {
					$reCnstr .= $cnNum[0];
				}
			}
		}
	}
	
	return $reCnstr;
}

$res = intToCnstr(1001);
var_dump($res);
