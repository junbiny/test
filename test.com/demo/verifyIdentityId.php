<?php
//验证身份证号: 本位码（前17）+ 校验码（最后一位）
function validation_filter_id_card($id_card)
{	
	//判断身份证号的长度
	if (strlen($id_card) == 18)
	{
		return idcard_checksum18($id_card);
	}
	else
	{
		return false;
	}
}

//验证身份人的出生日期
function idcard_verify_age($id_card)
{
	//出生年、月份、日期
	$birth_year  = substr($id_card, 6, 4);
	$birth_month = substr($id_card, 10, 2);
	$birth_day	 = substr($id_card, 12, 2);

	$month31	 = array(1,3,5,7,8,10,12);
	$month30	 = array(4,6,9,11);

	if ($birth_year > 2015 || $birth_year < 1900) {
		return false;
		// echo "出生年无效！";
	}
	elseif ($birth_month > 13 || $birth_month <= 0) {
		return false;
		// echo "出生月无效！";
	}
	elseif ($birth_month == 2) {
		if (($birth_year%4 == 0 && $birth_year%100 != 0) || ($birth_year%400 == 0 )) {
			if ($birth_day > 29 || $birth_day <= 0) {
				return false;
				// echo "出生日无效！";
			}
			else
				return true;
		}
		else
		{
			if ($birth_day > 28 || $birth_day <= 0) {
				return false;
				// echo "出生日无效！";
			}
			else
				return true;
		}
	}
	elseif (in_array($birth_month, $month31)) {
		if ($birth_day > 31 || $birth_day <= 0) {
			return false;
			// echo "出生日无效！";
		}
		else
		{
			return true;
			// echo $birth_year."年".$birth_month."月".$birth_day."日";
		}

	}
	elseif (in_array($birth_month, $month30)) {
		if ($birth_day > 30 || $birth_day <= 0) {
			return false;
			// echo "出生日无效！";
		}
		else
		{
			return true;
			// echo $birth_year."年".$birth_month."月".$birth_day."日";
		}
	}
}

//计算身份证校验码，根据国家标准GB 11643-1999
function idcard_verify_number($idcard_base)
{
	if (strlen($idcard_base) != 17)
	{
		return false;
	}
	//身份证号码17位数分别乘以不同的系数
	$factor = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);

	//校验码对应的值
	$verify_number_list = array('1','0','X','9','8','7','6','5','4','3','2');

	$checksum = 0;
	//将17位数字和系数相乘的结果相加
	for ($i=0; $i<strlen($idcard_base); $i++){
		$checksum += substr($idcard_base, $i, 1) * $factor[$i];
	}
	$mod = $checksum % 11;
	$verify_number = $verify_number_list[$mod];
	return $verify_number;
}

//检查18位身份证校验码的有效性
function idcard_checksum18($id_card)
{
	if (strlen($id_card) != 18)
	{
		return false;
	}

	//检查出生日期的有效性
	idcard_verify_age($id_card);

	//本位码
	$idcard_base = substr($id_card, 0, 17);
	if (idcard_verify_number($idcard_base) != strtoupper(substr($id_card, 17, 1)))
	{
		return false;
	}
	else
	{
		return true;
	}
}

$id_card = "222424200002295310";
$str = validation_filter_id_card($id_card);

if($str) 
 { 
 	echo "符合规则";
 } 
 else 
 { 
 	echo "不符合"; 
 }
