<?php
$data=array("1"=>100,"2"=>30,"3" =>150,4=>'120',5=>'182');

createImage($data,40,40,300);
/*
 * author http://www.phpernote.com/
* php生成柱状统计图程序
* $data 二维数组形式的数据
* $twidth 柱形宽度
* $tspace 两个柱形之间的距离
* $height 柱状图的高度
*/
function createImage($data,$twidth,$tspace,$height){
	header("Content-Type:image/jpeg");
	$dataname=array();
	$datavalue=array();//data里面的值
	$i=0;
	$j=0;
	$k=0;
	$num=sizeof($data);
	foreach($data as $key=>$val){
		$dataname[]=$key;
		$datavalue[]=$val;
	}
	$width=$num*($twidth+$tspace)+100 ;//获取图像的宽度
	$im=imagecreate($width,$height);//创建图像
	$bgcolor=imagecolorallocate($im,255,255,255);//背景色
	$jcolor=imagecolorallocate($im,255,0,0);//矩形的背景色
	$acolor=imagecolorallocate($im,0,0,0);//线的颜色
	imageline($im,25,$height-20,$width-5,$height-20,$acolor);//X轴
	imageline($im,25,$height-20,25,2,$acolor);//Y轴
	while($i<$num){
		imagefilledrectangle($im,$i*($tspace+$twidth)+40,$height-$datavalue[$i]-20,$i*($twidth+$tspace)+$tspace+40,$height-21,$jcolor);//画矩形
		imagestring($im,3,$i*($tspace+$twidth)+40+$twidth/2,$height-$datavalue[$i]-35,$datavalue[$i],$acolor);//在柱子上面写出值
		imagestring($im,3,$i*($tspace+$twidth)+40+$twidth/2,$height-15,$dataname[$i],$acolor);//在柱子下面写出值
		$i++;
	}
	while($j<($height)/10){
		imageline($im,25,($height-20)-$j*10,28,($height-20)-$j*10,$acolor);//画出刻度
		imagestring($im,2,5,($height-30)-$j*10,$j*10,$acolor);//标出刻度值
		$j=$j+10;
	}
	imagejpeg($im);
}