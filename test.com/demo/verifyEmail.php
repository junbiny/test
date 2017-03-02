<?php
//验证有效的邮箱

//目前比较受欢迎的正则表达式是：
// $pattern = "/^([a-zA-Z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
function checkEmail($email)
{
	$pattern = "/^([a-zA-Z0-9+_])+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
	$n = preg_match($pattern, $email);
	if (strpos($email, '@') !== false && strpos($email, '.') !== false)
	{
		if (!$n)
			return false;
		else
			return true;
	}
	else
		return true;	
}


/* ******************************************************************************* */

function verifyEmail($email)
{
	$isValid = true;
	$atIndex = strrpos($email, "@");	//最后一个@出现的位置
	//判断是否有@符号
	if (is_bool($atIndex) && !$atIndex)
	{
		$isValid = false;
	}
	else
	{
		//将Email分为：本地部分和域部分
		$local  = substr($email, 0, $atIndex);
		$domail = substr($email, $atIndex+1);

		// 判断本地部分和域部分的长度
		$localLen  = strlen($local);
		$domailLen = strlen($domail);
		if ($localLen < 1 || $localLen > 64)
		{
			$isValid = false;
		}
		elseif ($domailLen < 1 || $domailLen > 255)
		{
			$isValid = false;
		}
		//检查本地部分 点的位置
		elseif ($local[0] == '.' || $local[$localLen-1] == '.')
		{
			$isValid = false;
		}
		elseif (preg_match('/\\.\\./', $local))
		{
			$isValid = false;
		}
		//域检查
		// $domail_match = preg_match('/^[a-zA-Z0-9\\-\\.]+$/', $domail);
		elseif (!preg_match('/^[a-zA-Z0-9\\-\\.]+$/', $domail))
		{
			$isValid = false;
		}
		elseif (preg_match('/\\.\\./', $domail))
		{
			$isValid = false;
		}
		elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
	    {
	        // character not valid in local part unless 
	        // local part is quoted
	        if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
	        {
	            $isValid = false;
	        }
	    }
	    if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
	    {
	        // 检查DNS
	       	$isValid = false;
	    }
	}
    return $isValid;
}


//如果只是验证一般的邮箱直接调用checkEmail($email)

//更好的email校验器调用verifyEmail($email)


$email = "junbin3@leju.com";
$str = checkEmail($email);
if($str) 
 { 
 	echo "符合规则".$email;
 } 
 else 
 { 
 	echo "不符合"; 
 }
