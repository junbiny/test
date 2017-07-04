<?php
/**
 * 控制器基类
 * @author 
 *
 */
class control {
    /**
     * @var Smarty
     */
    protected $view;
    protected $c;
    protected $a;

    /**
     * 配置基本变量
     * Enter description here ...
     */
    public function __construct($c,$a) {
        $this->setView();
        $this->c = $c;
        $this->a = $a;
        $this->view->assign('a',$a);
        $this->view->assign('c',$c);
        $this->init();
    }

    public function init(){}

    /**
     * 获取参数
     * @param $key 参数名称
     * @param $type 验证的类型
     */
    protected function getParams($key, $type = 'string') {
        //$type验证类在global.func.php中的validate()方法中
        $key = ( isset($_POST[$key]) ) ? $_POST[$key] : (isset($_GET[$key])?$_GET[$key]:'');
        if (validate($key, $type)) {
            return $key;
        } else {
            return FALSE;
        }
    }

    /**
     * 页面元素
     */
    public function setView() {
        $this->view = new Smarty();
        $this->view->left_delimiter = '<{'; //设置左分割符号
        $this->view->right_delimiter = '}>'; //设置右分割符号
        $this->view->template_dir = ROOT . "view/"; //设置模板路径
        $this->view->compile_dir = CACHE_DIR . "templates_c/"; //设置模板编译路径
        $this->view->caching = false; //关闭缓存功能
    }
}