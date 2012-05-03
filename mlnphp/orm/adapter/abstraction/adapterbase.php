<?php

namespace MLNPHP\ORM\Adapter\Abstraction;

use \MLNPHP\MLNPHP;
/**
 * 数据库适配器基类
 * 
 * @package MLNPHP
 */
abstract class AdapterBase
{
    protected $connect;
    protected $conf;
    protected $lastQuery;
    protected $db;
    public $tables;
    protected static $dataType;

    const MYSQL = 'mysql';
    const SQLITE = 'sqlite';

    /**
     * 获取数据库适配器的实例
     * 
     * @param string $dbConfig 数据库配置点名称
     * 
     * @return Mixed
     */
    public static function getInstance($dbConfigName)
    {
        static $instance = array();
        
        $adapterType = ucfirst(MLNPHP::getApplication()->conf->db[$dbConfigName]['type']);
        $adapterClass = "\\MLNPHP\\ORM\\Adapter\\$adapterType\\$adapterType";

        if (!isset($instance[$dbConfigName])) {
            $instance[$dbConfigName] = new $adapterClass($dbConfigName);
        }

        return $instance[$dbConfigName];
    }

    /**
     * 获取数据库的数据类型
     * 
     * @return array
     */
    public static function getDataType()
    {
        return static::$dataType;
    }

    private function __construct($dbConfigName)
    {
        $application = MLNPHP::getApplication();
        $this->conf = $application->conf->db[$dbConfigName];
        $this->connect = $this->conn();
        $this->selectDb();
        $this->tables = $this->_withoutPrefix($this->getTables());
        
    }

    /**
     * 去除数据库表前缀并返回
     * 
     * @param array $tables 数据库
     * 
     * @return array
     */
    private function _withoutPrefix($tables)
    {
        $return = array();
        foreach ($tables as $tableName => $table) {
            $nameNoPrefix = str_replace($this->conf['prefix'], '', $tableName);
            $return[$nameNoPrefix] = $table;
        }
        return $return;
    }

    /**
     * 连接数据库
     * 
     * @return resource
     */
    abstract protected function conn();

    /**
     * 选取数据库
     * 
     * @return void
     */
    abstract protected function selectDb();

    /**
     * 获取数据库中的表
     * 
     * @return array
     */
    abstract public function getTables();

    /**
     * 数据库的Query方法
     * 
     * @param string $sql SQL语句
     * 
     * @return mixed
     */
    abstract public function query($sql);

    /**
     * 数据库的Fetch方法
     * 
     * @param resource $resource Query执行资源
     * 
     * @return array
     */
    abstract public function fetch($resource);    

    /**
     * 备份数据库
     * 
     * @return void
     */
    abstract public function backupDb();
    
    /**
     * 获取最近插入一条的ID
     * 
     * @return int 
     */
    abstract public function insertId();

    /**
     * 最后执行的SQL
     * 
     * @return void
     */
    public function getLastQuery()
    {
        echo $this->lastQuery;
    }

}