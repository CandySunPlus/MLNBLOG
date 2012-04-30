<?php
namespace MLNPHP\ORM\Adapter\Mysql;

use \MLNPHP\ORM\Adapter\Abstraction\AdapterBase;
use \MLNPHP\ORM\Adapter\Mysql\MysqlTable;
use \Exception;
/**
 * Mysql数据库适配器
 * 
 * @package MLNPHP
 */
class Mysql extends AdapterBase
{
    /**
     * 连接数据库
     * 
     * @return void
     */
    protected function conn()
    {
        $host = $this->conf['host'];
        $username = $this->conf['username'];
        $password = empty($this->conf['password']) ? '' : $this->conf['password'];

        $conn = mysql_connect($host, $username, $password);

        if (false === $conn) {
            throw new Exception('无法连接数据库');
        }
        return $conn;
    }

    /**
     * 选取数据库
     * 
     * @return void
     */
    protected function selectDb()
    {
        if (!mysql_select_db($this->conf['dbname'])) {
            throw new Exception(sprintf('无法选取数据库 %s', $this->conf['dbname']));
        }
        $this->db = $this->conf['dbname'];
    }

    /**
     * 获取数据库中的表
     * 
     * @return ArrayAccess
     */
    public function getTables()
    {
        $rs = $this->query(sprintf('SHOW TABLES FROM %s', $this->db));

        $tables = $this->fetch($rs);

        return $tables;
    }

    /**
     * 数据库的Query方法
     * 
     * @param string $sql SQL语句
     * 
     * @return mixed
     */
    public function query($sql)
    {
        $result = mysql_query($sql);
        if (false === $result) {
            throw new Exception(sprintf('SQL: %s 执行错误', $sql));
        }
        $this->lastQuery = $sql;
        return $result;
    }

    /**
     * 数据库的Fetch方法
     * 
     * @param resource $resource Query执行资源
     * 
     * @return ArrayAccess
     */
    public function fetch($resource)
    {
        $result = array();
        while ($row = mysql_fetch_array($resource, MYSQL_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * 备份数据库
     * 
     * @return void
     */
    public function backupDb()
    {

    }
}