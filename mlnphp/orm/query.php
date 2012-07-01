<?php
namespace MLNPHP\ORM;

use \MLNPHP\ORM\SQLBuilder;
class Query
{
    private $sqlBuilder;
    private static $adapter;
    private static $table;

    public function __construct($adapter, $table) 
    {
        self::$adapter = $adapter;
        self::$table = $table;
        $this->sqlBuilder = new SQLBuilder($table);
    }

    /**
     * 获取执行结果
     * 
     * @return array 
     */
    public function fetch()
    {
        $sql = (string)$this->sqlBuilder;
        $rs = self::$adapter->query($sql);
        return self::$adapter->fetch($rs);
    }
    
    /**
     * 魔法调用
     * 
     * @param string $funcname 函数名称
     * @param array $args 函数参数
     * 
     * @return mixed
     */
    public function __call($funcname, $args = array())
    {
        //TODO: if select have no param then return a entity
        call_user_func_array(array($this->sqlBuilder, $funcname), $args);
        return $this;
    }
}