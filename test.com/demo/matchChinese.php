<?php
$str = "学习php是一件快乐的事adf啊嘎嘎的fafdag回头玩儿。";

//匹配英文
// preg_match_all("/[x80-xff]+/", $str, $match);

//匹配中文
preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $str, $match);
var_dump($match[0]);