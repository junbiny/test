<?php
header("Content-type:text/html;charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

#其他包含文件
include './include/common.inc.php';

$c = htmlspecialchars(GET('c', 'index'),ENT_QUOTES); #获得页面
$a = htmlspecialchars(GET('a', 'index'),ENT_QUOTES); #获得行为

if(!preg_match("/^\w+$/", $c) || !preg_match("/^\w+$/", $a)){
    exit();
}

#系统级错误
try{
    #用户级错误 处理
    try{
        require ROOT . 'control/control.class.php';
        #导入相关类
        $control = $c . 'controller'; //亦可 => $control = $c . '_action';
        $appfile = ROOT . 'control/' . $control . '.class.php';

        if(file_exists($appfile)){
            include_once $appfile;
            
            $App = new $control($c, $a);

            if(method_exists($App, $a) && $a{0} != '_') {
                $App->$a();
            } else {
                exit($a . '_action not found!');
            }
        } else {
            exit('File not found!');
        }
    } catch(ErrorException $e){
        if(DEBUG){
            echo $e->getMessage()."<br />";
            echo $e->getFile();
            exit;
        }else{
            exit('action not found!');
        }
    }
}catch(Exception $e){

    if(DEBUG){
        echo $e->getMessage()."<br />";
        echo $e->getFile()."<br />";
        echo $e->getLine();
        exit;
    }else{
        exit('action not found!');
        exit;
    }
}