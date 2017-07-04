<?php
require_once ROOT . '/include/db/singleton.php';
require_once ROOT . '/include/db/mc.php';

define("_DB_INSERT", 1);
define("_DB_UPDATE", 2);
define("_DB_REPLACE", 3);

class db extends singleton {
    /**
     * 是否开启DEBUG
     * @var $debug boolean
     */
    private $debug = true;
    /**
     * 是否开启缓存
     * @var boolean
     */
    public $cache = CACHE;
    /**
     * PDO操作对象
     * @var PDO
     */
    public $db;
    /**
     * 当前sql指令
     * @var $queryStr string
     */
    protected $queryStr = '';
    /**
     * PDO 查询名柄对象
     * @var PDOStatement
     */
    private $smf;
    /**
     * 缓存操作对象
     * @var cls_mc
     */
    protected $mc;
    /**
     * 数据库连接集合
     * @var array
     */
    public static $db_link;
    protected $addslashes = true;

    /**
     * 是否抛出异常
     * @var unknown_type
     */
    public $exception = true;

    /**
     * 插入数据返回值
     */
    protected $primary = 'id';
    public $have_primary = true;
    public static $query_num = 0;

    /**
     * 数据库设置
     * @var string
     */
    protected $host, $port, $user, $password, $database;
    public $dbconfig = 'db_conf';
    protected function __construct() {
        $this->mc = mc::getInstance();
        $this->init();
    }

    public function init() {
    }

    private function getDb($i = 1) {
        if (!isset(self::$db_link[$this->dbconfig][$i])) {
            extract($GLOBALS[$this->dbconfig][$i]);
            $dsn = "mysql:host=$host;port=$port;dbname=$database";
            try {
                self::$db_link[$this->dbconfig][$i] = new PDO($dsn, $user, $password);
            }
            catch(PDOException $e) {
                $errstr = 'Connection failed: ' . $e->getMessage();
                if (DEBUG) {
                    echo $errstr;
                }
                if ($this->exception) {
                    throw new Exception($errstr);
                }
                return false;
            }
        }
        $this->db = self::$db_link[$this->dbconfig][$i];
        $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $this->setDb();
    }

    public function setDb($charset = 'UTF8') {
        $this->db->exec("SET NAMES  UTF8");
    }

    /**
     * @param $sql
     * @return int
     * conn的exec
     */
    public function exec($sql) {
        return $this->query($sql);
    }

    /**
     *
     * 数据库查询
     * @param sql $sql
     * @param 主从库 $db_router 0,1
     */
    public function query($sql, $db_router = NULL) {
        if (isset($_GET['testcache']) && DEBUG) {
            echo $sql . ' (' . self::$query_num . ')<br />';
            self::$query_num++;
        }
        try {
            //记录当前的sql语句
            $this->queryStr = $sql;
            if ($db_router === NULL) {
                $db_router = ('select' == strtolower(substr(trim($sql), 0, 6)) || 'desc' == strtolower(substr(trim($sql), 0, 4))) ? 1 : 0;
            } else {
                $db_router = $db_router ? 1 : 0;
            }
            $this->getDb($db_router);
            $status = $this->db->getAttribute(PDO::ATTR_SERVER_INFO);
            if ($status == 'MySQL server has gone away') {
                self::$db_link = null;
                //@wzb 再连还是gone away
                sleep(2);
                $this->getDb($db_router);
            }
            $this->smf = $this->db->prepare($sql);
            if (!$this->smf) {
                $errstr_tmp = $this->smf->errorInfo();
                if (DEBUG) {
                    echo "sql:" . $sql . "<hr />";
                    print_r($errstr_tmp);
                }
                if ($this->exception) {
                    $msg = debug_backtrace(); //错误跟踪
                    $error_file = '';
                    foreach ($msg as $val) {
                        $error_file.= $val['file'] . "->line" . $val['line'] . "\r\n";
                    }
                    throw new Exception("sql:" . $sql . "->\r\n" . $errstr_tmp[2] . "\r\nUTL:" . $_SERVER['PHP_SELF'] . "\r\nERROR FILE:" . $error_file);
                }
                return false;
            }
            $rs = $this->smf->execute();
            if (!$rs) {
                $errstr_tmp = $this->smf->errorInfo();
                if (DEBUG) {
                    echo "sql:" . $sql . "<hr />";
                    print_r($errstr_tmp);
                }
                if ($this->exception) {
                    $msg = debug_backtrace();
                    $error_file = '';
                    foreach ($msg as $val) {
                        $error_file.= $val['file'] . "->line" . $val['line'] . "\r\n";
                    }
                    throw new Exception("sql:" . $sql . "->\r\n" . $errstr_tmp[2] . "\r\nUTL:" . $_SERVER['PHP_SELF'] . "\r\nERROR FILE:" . $error_file);
                }
                return false;
            }
        }
        catch(PDOException $e) {
            $errstr = 'query failed: ' . $e->getMessage();
            if (DEBUG) {
                echo $errstr;
            }
            if ($this->exception) {
                $msg = debug_backtrace();
                $error_file = '';
                foreach ($msg as $val) {
                    $error_file.= $val['file'] . '->';
                }
                throw new Exception($errstr . 'ERROR FILE:' . $error_file);
            }
            return false;
        }
        return true;
    }

    /**
     * 数据库插入操作
     *
     * @param array $info
     * @return int
     */
    public function insert($info, $table, $ignore = false) {
        if ($this->addslashes) {
            $info = array_map('daddslashes', $info);
        }
        $key = '`' . implode('`,`', array_keys($info)) . '`';
        $value = "'" . implode('\',\'', array_values($info)) . "'";
        $sql = "insert " . ($ignore ? "ignore " : "") . "into $table ($key) values ($value)";
        $rs = $this->query($sql);
        if ($this->have_primary) {
            return $this->db->lastInsertId($this->primary);
        } else {
            return $rs;
        }
    }

    /**
     * 数据replace操作
     * @param unknown $info
     * @param unknown $table
     * @return Ambigous <boolean, string>
     */
    public function replaceInto($info, $table) {
        if ($this->addslashes) {
            $info = array_map('daddslashes', $info);
        }
        $key = '`' . implode('`,`', array_keys($info)) . '`';
        $value = "'" . implode('\',\'', array_values($info)) . "'";
        $sql = "replace into $table ($key) values ($value)";
        $rs = $this->query($sql);
        if ($this->primary) {
            $rs = $this->db->lastInsertId($this->primary);
        }
        return $rs;
    }

    public function update($info, $table, $where) {
        if ($this->addslashes) {
            $info = array_map('daddslashes', $info);
        }
        $set_info = array();
        foreach ($info as $key => $value) {
            $set_info[] = "`" . $key . "`='" . $value . "'";
        }
        $set_str = implode(',', $set_info);
        $sql = "update $table set $set_str $where";
        return $this->exec($sql);
    }

    /**
     * 取符合条件的一条记录
     * 未转义参数,有可能造成漏洞
     * @param sql $sql
     * @return array
     */
    public function fetch($sql, $db_router = NULL) {
        if ($this->cache) {
            $key = md5($sql);
            $result = $this->mc->get($key);
            if ($result === false) {
                $this->query($sql);
                $result = $this->smf->fetch(PDO::FETCH_ASSOC);
                $this->mc->set($key, $result);
            }
        } else {
            $this->query($sql, $db_router);
            $result = $this->smf->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    public function fetchCol($sql, $n = 0) {
        $this->query($sql);
        return $this->smf->fetchAll(PDO::FETCH_COLUMN, $n);
    }

    /**
     * 事物封装处理
     * 没有经过测试
     * @param array $sql_arr
     */
    public function run($sql_arr) {
        $this->getDb(0);
        $this->db->beginTransaction();
        foreach ($sql_arr as $sql) {
            echo $sql . '<br />';
            $rs = $this->db->exec($sql);
            echo $rs . ':' . $sql . '<br />';
        }
        if (!$this->db->commit()) {
            $this->db->rollBack();
            return false;
        }
        return true;
    }

    /**
     * 取出所有满足条件的数据
     * 未转义参数,有可能造成漏洞
     * @param string $sql
     * @return array
     */
    public function fetchAll($sql, $nocache = false) {
        $mc_key = md5($sql);
        $db_key = md5('db_' . $sql);
        $db_state = $this->mc->get($db_key);
        $db_state = false;
        if ($db_state === false) {
            $this->mc->set($db_key, 1);
            //
            if ($this->cache) {
                $result = $nocache ? false : $this->mc->get($mc_key);
                if ($result === false) {
                    $this->query($sql);
                    $result = $this->smf->fetchAll(PDO::FETCH_ASSOC);
                    $this->mc->set($mc_key, $result);
                } else {
                    //echo 'cached: '.$sql.' <br />';
                    
                }
            } else {
                $this->query($sql);
                $result = $this->smf->fetchAll(PDO::FETCH_ASSOC);
            }
            //
            $this->mc->set($db_key, false);
        } else {
            sleep(1);
            $this->fetchAll($sql, $nocache);
        }
        return $result;
    }

    public function clear_cache($sql) {
        $key = md5($sql);
        $this->mc->set($key, NULL);
    }
    /**
     * 扩展取单一字段
     * 未转义参数,有可能造成漏洞
     * @param string $sql
     * @return str
     */
    public function fetchOne($sql, $is_slave = NULL) {
        if ($this->cache) {
            $key = md5($sql);
            $result = $this->mc->get($key);
            if ($result === false) {
                $this->query($sql, $is_slave);
                $result = $this->smf->fetch();
                $result = $result[0];
            }
        } else {
            $this->query($sql, $is_slave);
            $result = $this->smf->fetch();
            $result = $result[0];
        }
        return $result;
    }

    /**
     * 获取最近一次查询的SQL语句
     */
    public function getLastSql() {
        return $this->queryStr;
    }

    public function __wakeup() {
        $this->getDb();
    }

    public function __sleep() {
        $this->db = null;
        return array('db', 'variable', 'dbconfig');
    }
    /**
     * 合成limit 语句
     * @param int $p
     * @param int $num
     * @param int $max
     * @return sql limit str
     */
    public function getLimit($p, $num, $max = 50) {
        if (!is_numeric($p) || !is_numeric($num)) {
            throw new Exception('参数错误');
            exit;
        }
        $p = ($p > 0) ? $p : 1;
        if ($p > $max) {
            throw new Exception("分页受限为{$max}页");
            $p = $max;
        }
        $offset = ($p - 1) * $num;
        return " limit $offset, $num";
    }

    public function getOne($sql, $field = '', $isMaster = false) {
        return $this->fetchOne($sql);
    }

    public function getRow($sql, $isMaster = false) {
        return $this->fetch($sql);
    }

    public function getAll($sql, $isMaster = false) {
        return $this->fetchAll($sql);
    }

    public function execute($sql) {
        return $this->query($sql);
    }
    
    public function autoExecute($table, $arrField, $mode, $where = '', $isMaster = false) {
        if ($table == '' || !is_array($arrField) || empty($arrField)) {
            return false;
        }
        //$mode为1是插入操作(Insert), $mode为2是更新操作
        if ($mode == 1) {
            $sql = " INSERT INTO `$table` SET ";
        } elseif ($mode == 2) {
            $sql = " UPDATE `$table` SET ";
        } elseif ($mode == 3) {
            $sql = " REPLACE INTO `$table` SET  ";
        } else {
            throw new Exception("Operate type '$mode' is error, in call DB::autoExecute process table $table.");
            return false;
        }
        foreach ($arrField as $key => $value) {
            $sql.= "`$key`='$value',";
        }
        $sql = rtrim($sql, ',');
        if ($mode == 2 && $where != '') {
            $sql.= " WHERE $where ";
        }
        return $this->execute($sql, $isMaster);
    }
}
