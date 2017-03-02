<?php
function verify_phone($tel)
{
	//验证手机号是不是11位
	if(strlen($tel) == 11)
	{	
		
		//移动：1340-1348、135、136、137、138、139、147、150、151、152、157、158、159、182、183、187、188。
		//联通：130、131、132、145、155、156、185、186、177。
		//电信：133、153、180、189。

		$pattern = "/^13[0-9]{9}$|14[5|7]{1}[0-9]{8}$|15[0-9]{9}$|177[0-9]{8}$|18[0-9]{9}$/";
		$n = preg_match($pattern,$tel);

		if($n)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	else
	{
		return false;
	}
}

$str = verify_phone("17701052608");
if($str) 
 { 
 	echo "符合规则";
 } 
 else 
 { 
 	echo "不符合"; 
 } 