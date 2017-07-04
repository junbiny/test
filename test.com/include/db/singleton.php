<?php
abstract class singleton
{
    protected function __construct()
    {
    }
    final public static function getInstance()
    {
        static $aoInstance = array();
        $calledClassName = get_called_class();
        if(!isset($aoInstance[$calledClassName]))
        {
            $aoInstance[$calledClassName] = new $calledClassName();
        }
        return $aoInstance[$calledClassName];
    }
    public function __isset($name)
    {
        return isset($this->$name);
    }
    public function __get($name)
    {
        if(isset($this->$name))
        {
            return $this->$name;
        }
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    public function __set_state($array)
    {
    }
    public function __call($funName, $args)
    {
        if(!isset($this->$funName))
        {
            throw new Exception($funName . '方法不存在');
            return;
        }
    }
}