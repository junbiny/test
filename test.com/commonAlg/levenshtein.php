<?php
#levenshtein() 函数返回两个字符串之间的 Levenshtein 距离，
#levenshtein距离，又称编辑距离，指的是两个字符串之间，由一个字符串转换成另一个字符串所需的最少编辑操作次数。许可的编辑操作包括将一个字符替换成另一个字符，插入一个字符，删除一个字符。
echo levenshtein('Kooxoo.com', 'kooxoo.com');
echo '<br />';

#range() 函数创建并返回一个包含指定范围的元素的数组
$date = range('2015', '2025');
#var_dump($date);


#把数组array(12,34,56,32) 转化为 array(1,2,3,4,5,6,3,2)
$arr = array(12,34,56,32);
$str = implode('', $arr);
$new_str = str_split($str, 1);
#var_dump($new_str);

#已知字符串 $string = "2dsjfh87HHfytasjdfldiuuidhfcjh";找出 $string 中出现次数最多的所有字符。
$string = "2dsjfh87HHfytasjdfldiuuidhfcjh";
$re = count_chars($string, 1);
$arr = array_keys($re, max($re));
$res = array_map("chr", $arr);
var_dump($res);

$sst = str_split($string, 1);
$acv = array_count_values($sst);
$ak = array_keys($acv, max($acv));
var_dump($ak);