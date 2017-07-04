<?php
class mc extends singleton
{
    private $prefix;
    private $_self;
    protected function  __construct()
    {   
        if(!$this->_self instanceof Memcache)
        {
            $this->_self = new Memcache();
            $servers = explode(" ",$_SERVER["SINASRV_MEMCACHED_SERVERS"]);
            foreach($servers as $key => $val)
            {
                $v = explode(":",$val);
                $this->_self->addServer($v[0],$v[1]);
            }
            $this->prefix = $_SERVER["SINASRV_MEMCACHED_KEY_PREFIX"];
        }
    }
    public function set($key, $value, $time = '300')
    {
        return $this->_self->set($this->prefix.$key, $value, 0, $time);
    }
    public function get($key)
    {
        return $this->_self->get($this->prefix.$key);
    }
    public function delete($key)
    {
        return $this->_self->delete($this->prefix.$key);
    }
    
    public function flush()
    {
        return $this->_self->flush();
    }
}
?>
