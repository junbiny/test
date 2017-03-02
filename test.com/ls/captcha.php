<?php
session_start();
header ('Content-Type:image/png');
#创建图片
$image = imagecreatetruecolor(88, 38);
#白色背景
$bgcolor = imagecolorallocate($image, 255, 255, 255);
#填充
imagefill($image, 0, 0, $bgcolor);

#产生随机字符
$captcha_code = '';
for ($i=0; $i < 4; $i++) { 
	$fontsize = 15;
	$fontcolor = imagecolorallocate($image, 255, 0, 0);
	$data = 'abcdefghijkmnpqrstuvwxy3456789ABCDEFGHJKLMNPQRSTUVWXYZ';
	$fontcontent = substr($data, rand(0, strlen($data)), 1);
	$captcha_code .= $fontcontent;
	
	$x = $i*15+ rand(10, 12);
	$y = rand(22, 25);

// 	imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
	imagettftext($image, $fontsize, rand(-10, 10), $x, $y, $fontcolor, 'font/tahoma.ttf', $fontcontent);
}
$_SESSION['authcode'] = $captcha_code;

#干扰点
for ($i=0; $i < 100; $i++) { 
	# code...
	$pointcolor = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
	imagesetpixel($image, rand(1,109), rand(1,29), $pointcolor);
}

#干扰线
for ($i=0; $i < 2; $i++) { 
	# code...
	$linecolor = imagecolorallocate($image, rand(80,220), rand(80,220), rand(80,220));
	imageline($image, rand(1,109), rand(1,29), rand(1,109), rand(1,29), $linecolor);
}

imagepng($image);
imagedestroy($image);

