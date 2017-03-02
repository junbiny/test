<?php 
function downserver(){
	$file_name = '';
	$file_path = "./img/".$file_name;

	//转码，文件名转为gb2312解决中文乱码
	$file_name = iconv("utf-8","gb2312",$file_name);
	$file_path = iconv("utf-8","gb2312",$file_path);
	$fp = fopen($file_path,"r") or exit("文件不存在");

	//定义变量空着每次下载的大小
	$buffer = 1024;

	//得到文件的大小
	$file_size = filesize($file_path);
	//header("Content-type:text/html;charset=gb2312");
	//会写用到的四条http协议信息
	header("Content-type:application/octet-stream");
	header("Accept-Ranges:bytes");
	header("Accept-Length: ".$file_size);
	header("Content-Disposition:attachment;filename=".$file_name);
	//字节技术器，纪录当前现在字节数
	$count = 0;
	while(!feof($fp) && $file_size-$count>0){
		//从$fp打开的文件流中每次读取$buffer大小的数据
		$file_data = fread($fp,$buffer);
		$count+=$buffer;
		//将读取到的数据读取出来
		echo $file_data;
	}
	//关闭文件流
	fclose($fp);
 }