<?php
function verify_name($name)
{
	$pattern = "/^[\x{4e00}-\x{9fa5}]+$/u";
	$n = preg_match($pattern,$name);

	if ($n)
	{
		return true;
	}
	else
	{
		return false;
	}

}

$str = verify_name("中文吼吼");
if($str) 
 { 
 	echo "符合规则";
 } 
 else 
 { 
 	echo "不符合"; 
 }