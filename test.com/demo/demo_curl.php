<?php

/**
 * 获取url返回值，curl方法
 */
function get_url($url, $timeout = 20) {
	//初始化一个cURL对象
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);//设置需要抓取的URL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//获取数据返回
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$ret = curl_exec($ch);//运行cURL，请求网页
	curl_close($ch);
	return $ret;
}

/**
 * 提交post请求，curl方法
 *
 * @param string $url         请求url地址
 * @param array  $post_fields 变量数组
 * @return string             请求结果
 */
function post_url($url, $post_fields, $timeout = 10) {
	$post_data = curl_build_query($post_fields);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);//设置需要抓取的URL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//获取数据返回
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$ret = curl_exec($ch);//运行cURL，请求网页
	curl_close($ch);
	return $ret;
}

/**
 * CURL 请求参数拼接,参数值使用urlencode编码
 *
 * @param array $params
 * @return string
 */
function curl_build_query($params) {
	$params = (array) $params;
	$curl_query = '';
	foreach ($params as $k => $v) {
		$curl_query .= "$k=" . urlencode($v) . "&";
	}
	$curl_query = substr($curl_query, 0, -1);
	return $curl_query;
}

//例子
$url = 'http://test.admin.house.sina.com.cn/new/api/getuser';
$key = '7614efd0d453bebb68aef948bc4f7c5e';// 测试机
#$key = '04e4707f6e8f4f9dca586eabdb39c3d2';// 正式线
$uid = '2116241223';

$post_fields = array('key'=>$key, 'uid'=>$uid);
$data = post_url($url, $post_fields);
$data = json_decode($data, true);
if ($data['result']) {
	#var_dump($data['userinfo']);
} 