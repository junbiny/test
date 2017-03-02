<?php
header("Content-type:text/html;charset=utf-8"); 
echo getFirstChar('钛攸臧鑫《臧克家》');

function getFirstChar($str)
{
	if (empty($str)) {
		return '';
	}

	#过滤掉书名符 "《"，"》"
	$find_str = array("《", "》");
	foreach ($find_str as $v) {
		$str = str_replace($v, '', $str);
	}

	#截取第一个字符
	$firstStr = mb_substr($str, 0, 1, 'UTF-8');
	#返回字符的 ASCII 码值
	$asc = ord($firstStr);
	
	#非中文还是中文
	if ($asc < 160) {
		#是数字、大写英文字母，则直接返回；是小写英文，则将其变成大写字母返回
		if ($asc>=48 && $asc<=57) {
            return chr($asc);   //数字
        }elseif ($asc>=65 && $asc<=90) {
            return chr($asc);   // A--Z chr将ASCII转换为字符  
        }elseif ($asc>=97 && $asc<=122) {
            return chr($asc-32); // a--z  
        }else
        	return null;
	} else {
		// var_dump($firstStr);
		#取GB2312字符串首字母,原理是GBK汉字是按拼音顺序编码的.
		$s=iconv("UTF-8","gb2312", $firstStr);
		$asc=ord($s{0})*256+ord($s{1})-65536;
		
		// var_dump($asc);
		if($asc>=-20319 and $asc<=-20284) return "A";
		if($asc>=-20283 and $asc<=-19776) return "B";
		if($asc>=-19775 and $asc<=-19219) return "C";
		if($asc>=-19218 and $asc<=-18711) return "D";
		if($asc>=-18710 and $asc<=-18527) return "E";
		if($asc>=-18526 and $asc<=-18240) return "F";
		if($asc>=-18239 and $asc<=-17923) return "G";
		if($asc>=-17922 and $asc<=-17418) return "H";
		if($asc>=-17417 and $asc<=-16475) return "J";
		if($asc>=-16474 and $asc<=-16213) return "K";
		if($asc>=-16212 and $asc<=-15641) return "L";
		if($asc>=-15640 and $asc<=-15166) return "M";
		if($asc>=-15165 and $asc<=-14923) return "N";
		if($asc>=-14922 and $asc<=-14915) return "O";
		if($asc>=-14914 and $asc<=-14631) return "P";
		if($asc>=-14630 and $asc<=-14150) return "Q";
		if($asc>=-14149 and $asc<=-14091) return "R";
		if($asc>=-14090 and $asc<=-13319) return "S";
		if($asc>=-13318 and $asc<=-12839) return "T";
		if($asc>=-12838 and $asc<=-12557) return "W";
		if($asc>=-12556 and $asc<=-11848) return "X";
		if($asc>=-11847 and $asc<=-11056) return "Y";
		if($asc>=-11055 and $asc<=-10247) return "Z";
		
		if($asc > -10247 or $asc < -20319) return getOtherChar($asc);
	}
	
}

function getOtherChar($asc)
{
	if($asc == -2354) return "X"; //鑫
	if($asc == -5456) return "Z"; //臧
	if($asc == -9988) return "Y"; //攸
	if($asc == -4399) return "T"; //钛
	return null; 
}