<?php
include 'conn.php';

$username = htmlspecialchars($_POST['username']);
$password = MD5($_POST['password']);

$sql = "select * from member where username='$username' and password='$password' limit 1";
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetch(PDO::FETCH_ASSOC);

#验证是够正确
$data = array('status'=>1, 'msg'=>'正确');
if (empty($res)) {
	$msg = '用户名与密码不正确！';
}

echo json_encode($data);