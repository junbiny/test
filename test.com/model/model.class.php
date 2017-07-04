<?php
/**
 * 模型基类
 * @author 
 *
 */
class model
{
    /**
     * @var db
     */
    protected $db;

    //public $

    public function __construct()
    {
        $this->db = db::getInstance();
        global $cfg, $lang, $common_lang;
		$this->cfg = $cfg;
		$this->lang = $lang;
		$this->common_lang = $common_lang;
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        else
        {
            return NULL;
        }
    }

    public function getDb()
    {
        return $this->db;
    }
}