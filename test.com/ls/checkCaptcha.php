<?php
session_start();
#验证码的值
$authcode = $_SESSION['authcode'];
#post请求过来的值
$resData = $_POST['idcode'];

$data = array('status'=>1,'msg'=>'验证码正确！');

if ($resData == '') {
	$data['status'] = 0;
	$data['msg'] = '验证码不能为空,请重新输入！';
}

if ($resData != '' && $resData != $authcode) {
	$data['status'] = 0;
	$data['msg'] = '验证码错误！';
}
echo json_encode($data);
