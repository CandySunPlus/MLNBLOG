<?php
namespace MLNPHP\ORM\Adapter\Abstraction;

/**
 * 数据库表基类
 * 
 * @package MLNPHP
 */
abstract class TableBase
{
    protected $db;
    protected $primaryKey;
    protected $fields;
    protected $tableName;

    public function __construct($db, $tableName)
    {
        $this->db = $db;
        $this->tableName = $tableName;
        $this->getTable();
    }

    /**
     * 获取表中的字段
     * 
     * @return ArrayAccess
     */
    abstract protected function getFields();

    /**
     * 获取表
     * 
     * @return void
     */
    protected function getTable()
    {
        $this->fields = $this->getFields();
        $this->primaryKey = $this->getPrimaryKey();
    }

    /**
     * 获取主键
     * 
     * @return string
     */
    protected function getPrimaryKey()
    {
        foreach ($this->fields as $fieldName => $fieldData) {
            if ($fieldData->isPrimaryKey) {                
                return $fieldName;
            }
        }
    }

    /**
     * 备份表
     * 
     * @return void
     */
    abstract protected function backup();
}