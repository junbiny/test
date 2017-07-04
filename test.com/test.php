<?php
/*
 * @desc 获取图片大小
 */
function MyImg($imgfile) {
	$size = getimagesize($imgfile);
	echo "<img src=\"$imgfile\" $size[3]>";
	echo "<br />";
	echo "<img src='{$imgfile}' {$size[3]}>";
}
#MyImg("http://static.codeceo.com/images/2015/09/weibo-logo-03.png");


/*
 * @desc 写一个函数，尽可能高效的，从一个标准 url 里取出文件的扩展名
 */
function getExtensionName( $url) {
	$arr_url = parse_url($url);
	$path = $arr_url['path'];
	#判断是否有.
	$is_ext = strpos($path, '.');
	if ($is_ext !== false) {
		$ext = explode('.', $path);
		return $ext[1];
	} else {
		return false;
	}
}
$url = "http://www.sina.com.cn/abc/de/fg.php?id=1";
#echo getExtensionName($url);


/*
 * @desc 小球初始高度100，每次下落弹起个高度为上次弹起高度的一半，求第n次落地时的路程
 */
function totalLen($n) {
	$totalLen = 0;
	if ($n === 0) {
		$totalLen = 0;
	}
	if ($n === 1) {
		$totalLen = 100;
	}

	#n > 1
	if ($n > 1) {
	$i = 2;
	$totalLen = 100;

	while ($i <= $n) {
	#第n-1次后弹起的高度,n>1
		$hight_n = 100/pow(2, ($i-1));
		$tmp = $hight_n * 2;
		$totalLen += $tmp;
		$i++;
	}
	}
	return $totalLen;
}
#$len = totalLen(10);
#var_dump($len);

/*
 * @desc fsockopen()的例子 
 * @desc 抓取远程图片到本地,你会用什么函数
 */
function getRemoteInfo() {
	$fp = fsockopen("www.example.com", 80, $errno, $errstr, 30);
	if (!$fp) {
		echo "$errstr ($errno)<br />\n";
	} else {
		$out = "GET / HTTP/1.1\r\n";
	    $out .= "Host: www.example.com\r\n";
	    $out .= "Connection: Close\r\n\r\n";
	    
	    fwrite($fp, $out);
	    while (!feof($fp)) {
	    	echo fgets($fp, 128);
	    }
	    fclose($fp);
	}
}
#getRemoteInfo();


/*
 * @desc 随机数
 */
function sevenRand() {
	$str = rand(1,33).' '.rand(1,33).' '.rand(1,33).' '.rand(1,33).' '.rand(1,33).' '.rand(1,33).' ';
	$str .= '+' . rand(1, 16);
	
	return $str;
}
#echo sevenRand();


/*
 * @desc 用最少的代码写一个求3值最大值的函数.
 */
function getMaxNumber($a, $b, $c) {
	return $a > $b ? ($a>$c?$a:$c) : ($b>$c?$b:$c);
}
#echo getMaxNumber(23, 58, 77);


/*
 * @desc make_by_id” 转换成 ”MakeById”
 */
function str_change($string) {
	/* 方法一 */
	/* $strArr = explode('_', $string);
	 foreach ($strArr as $key => $val){
	$strArr[$key] = ucfirst($val);
	}
	$newStr = implode('', $strArr);
	return $newStr; */

	/* 方法二 */
	$str = str_replace('_', ' ', $string);
	$str = ucwords($str);
	$newStr = str_replace(' ', '', $str);

	return $newStr;
}
#$newStr = str_change('make_by_id');
#var_dump($newStr);


/*
 * @desc 提示
 */
function msg_alert($msg, $url){
	echo '<script type="text/javascript">
                alert("' . $msg . '");
                document.location.href="' . $url . '";
          </script>';
	exit;
}


/*
 * @desc 上传文件
 */
function upload_file() {
	$file_type = $_FILES['file']['type'];
	$file_size = $_FILES['file']['size'];

	#限制大小
	if ($file_size > 1000) {
		#msg_alert('文件过大！请重新上传。', 'http://test.com/upload.html');
	}
	#限制文件类型
	if ($file_type != 'text/plain') {
		msg_alert('文件格式不符！请重新上传。', 'http://test.com/upload.html');
	}

	if ($_FILES['file']['error'] > 0) {
		echo "Error: " . $_FILES['file']['error'] . "<br />";
	} else {
		echo "文件名称: " . $_FILES["file"]["name"] . "<br />";
		echo "文件类型: " . $_FILES["file"]["type"] . "<br />";
		echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		echo "临时存储目录: " . $_FILES["file"]["tmp_name"] . "<br />";
	}

	#保存到服务器中
	$filedir = "C:/Application/cache/upload_files/" . $_FILES['file']['name'];

	if (file_exists($filedir)) {
		$already =  $_FILES['file']['name'] . " 已经存在!";
		msg_alert($already, 'http://test.com/upload.html');
	} else {
		move_uploaded_file($_FILES["file"]["tmp_name"], $filedir);
		chmod($filedir, 0755);
		echo "保存在: " . $filedir;
	}
}
#upload_file();


/**
 * @desc 有m只猴子，从1开始数到n，第m只猴子退出，如此循环执行下去，直到剩下最后一只猴子，求该猴子的编号？
 *
 * 递归算法
 * @param int $n 猴子数
 * @param int $m 出局数
 * @param int $i 指针
 */
function KingMonkey($n, $m) {
	for($i=1 ;$i<=$n ;$i++){
		$monkeys[] = $i;
	}

	#设置数组指针
	$i = 0;
	#遍历数组，判断当前猴子是否为出局序号，如果是则出局，否则放到数组最后
	while (count($monkeys) > 1) {
		if (($i+1) % $m == 0) {
			unset($monkeys[$i]);
		} else {
			#本轮非出局猴子放数组尾部
			array_push($monkeys, $monkeys[$i]);
			#删除
			unset($monkeys[$i]);
		}
		$i++;
	}

	return $monkeys;
}
#var_dump(KingMonkey(8,5));

/**
 * @desc 检查地址是否有效
 * @param string $url
 * @return bool
 */
function varify_url($url) {
	$check = @fopen($url,"r");
	if($check)
		$status = true;
	else
		$status = false;
	return $status;
}
#var_dump(varify_url('http://bj.leju.com'));




