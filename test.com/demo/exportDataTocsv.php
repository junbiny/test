<?php
$data = array(
			0=>array('media_name'=>'1大伟，蚊了什么','article_num'=>'123'),
			1=>array('media_name'=>'2门市，斯蒂芬','article_num'=>'134'),
			2=>array('media_name'=>'3就是','article_num'=>'63'),
			3=>array('media_name'=>'4没玩','article_num'=>'58'),
		);

#文件名
$filename = date('YmdHis').".csv";

header("Content-type:text/csv");
header("Content-Disposition:attachment;filename=".$filename);
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Expires:0'); 	#当前文档禁用缓存
header('Pragma:public');

#列名
$str = "排序,媒体作者,文章数\n";
$str = iconv('utf-8','gb2312',$str);
foreach ($data as $k => $v) {
	$id	  = $k + 1;
	$name = iconv('utf-8', 'gb2312', $v['media_name']);
	$num  = iconv('utf-8', 'gb2312', $v['article_num']);
    	
	$str .= $id.",".$name.",".$num."\n"; //用引文逗号分开 
}
echo $str;
