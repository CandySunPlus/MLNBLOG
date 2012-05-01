<?php
namespace MLNPHP\ORM\Adapter\Abstraction;

/**
 * 数据库表基类
 * 
 * @package MLNPHP
 */
abstract class TableBase
{
    protected $adapter;
    public $primaryKey;
    public $fields;
    public $tableName;

    public function __construct($adapter, $tableName)
    {
        $this->adapter = $adapter;
        $this->tableName = $tableName;
        $this->getTable();
    }

    /**
     * 获取表中的字段
     * 
     * @return array
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
     * @return mixed
     */
    protected function getPrimaryKey()
    {
        foreach ($this->fields as $fieldName => $fieldData) {
            if ($fieldData['isPrimaryKey']) {                
                return $fieldName;
            }
        }

        return null;
    }

    /**
     * 备份表
     * 
     * @return void
     */
    abstract protected function backup();
}