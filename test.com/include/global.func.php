<?php
if(!function_exists('get_called_class')){
    function get_called_class($bt = false, $l = 1){
        set_time_limit(0);
        if(!$bt)
            $bt = debug_backtrace();
        if(!isset($bt[$l]))
            throw new Exception("Cannot find called class -> stack level too deep.");
        if(!isset($bt[$l]['type']))
        {
            throw new Exception('type not set');
        }
        else
            switch($bt[$l]['type'])
            {
            	case '::':
            	    $lines = file($bt[$l]['file']);
            	    $i = 0;
            	    $callerLine = '';
            	    do
            	    {
            	        $i++;
            	        $callerLine = $lines[$bt[$l]['line'] - $i] . $callerLine;
            	    }
            	    while(stripos($callerLine, $bt[$l]['function']) === false);
            	    preg_match('/([a-zA-Z0-9\_]+)::' . $bt[$l]['function'] . '/', $callerLine, $matches);
            	    if(!isset($matches[1]))
            	    {
            	        // must be an edge case.
            	        throw new Exception("Could not find caller class: originating method call is obscured.");
            	    }
            	    switch($matches[1])
            	    {
            	    	case 'self':
            	    	case 'parent':
            	    	    return get_called_class($bt, $l + 1);
            	    	default:
            	    	    return $matches[1];
            	    }
            	    // won't get here.
            	case '->':
            	    switch($bt[$l]['function'])
            	    {
            	    	case '__get':
            	    	    // edge case -> get class of calling object
            	    	    if(!is_object($bt[$l]['object']))
            	    	        throw new Exception("Edge case fail. __get called on non object.");
            	    	        return get_class($bt[$l]['object']);
            	    	default:
            	    	    return $bt[$l]['class'];
            	    }
            	default:
            	    throw new Exception("Unknown backtrace method type");
            }
    }
}

/**
 * 获取url返回值，curl方法
 */
function get_url($url, $timeout = 20) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($ch);
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
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $ret = curl_exec($ch);
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

#安全地获得$_GET值,防止notice级别错误
function GET($para, $val = '') {
    return isset($_GET[$para]) ? $_GET[$para] : $val;
}

#安全地获得$_POST值,防止notice级别错误
function POST($para, $val = '') {
    return isset($_POST[$para]) ? $_POST[$para] : $val;
}

/**
 * 验证方法
 * @param $params 所要验证的值
 * @param $type 验证的类型
 */
function validate($params, $type = 'string') {
    $validate = array(
            'string' => '//',
            'require' => '/.+/',
            'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url' => '/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/',
            'currency' => '/^\d+(\.\d+)?$/',
            'number' => '/^\d+$/',
            'zip' => '/^[1-9]\d{5}$/',
            'integer' => '/^[-\+]?\d+$/',
            'double' => '/^[-\+]?\d+(\.\d+)?$/',
            'english' => '/^[A-Za-z]+$/',
            'qq' => '/^[1-9]\d{1,10}$/',
            'telephone' => '/^[0-9-()]+$/',
            'phonenum' => '/1[3-8][0-9]{9}+$/'
    );
    // 检查是否有内置的正则表达式
    if (isset($validate[strtolower($type)]))
        $type = $validate[strtolower($type)];
    return preg_match($type, $params) === 1;
}

#转义
function daddslashes($string, $force = 0) {
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if (!MAGIC_QUOTES_GPC || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);
            }
        } else {
            //$string = addslashes(trim(str_replace(array('０','１','２','３','４','５','６','７','８','９'),array('0','1','2','3','4','5','6','7','8','9'),$string)));
            $string = addslashes(trim($string));
        }
    }
    return $string;
}