<?php
namespace MLNPHP\ORM\Adapter\Mysql;

use \MLNPHP\ORM\Adapter\Abstraction\TableBase;
use \stdClass;

/**
 * Mysql 数据库表类
 * 
 * @package MLNPHP
 */
class MysqlTable extends TableBase
{
    /**
     * 获取表中的字段
     * 
     * @return array
     */
    protected function getFields()
    {
        $sql = sprintf('SHOW COLUMNS FROM %s', $this->tableName);
        $rs = $this->adapter->query($sql);
        $fields = $this->adapter->fetch($rs);

        $return = array();
        foreach ($fields as $fieldData) {
            $return[] = $this->_getFieldByData($fieldData);
        }

        return $return;
    }

    /**
     * 备份表
     * 
     * @return void
     */
    protected function backup()
    {

    }

    /**
     * 根据字段数据生成字段对象
     * 
     * @param array $fieldData 字段数据
     * 
     * @return stdClass
     */
    private function _getFieldByData($fieldData)
    {
        
        $field = new stdClass;
        $typeAndScope = $this->_parseTypeAndScope($fieldData['Type']);
        
        $field->name = $fieldData['Field'];
        $field->type = $typeAndScope->type;
        $field->scope = $typeAndScope->scope;
        $field->null = $fieldData['Null'];
        $field->default = $fieldData['Default'];
        $field->extra = $fieldData['Extra'];
        $field->isPrimaryKey = ('PRI' == $fieldData['Key']) ? true : false;

        return $field;
    }

    /**
     * 分析类型和范围
     * 
     * @param string $type 类型和范围字符串
     * 
     * @return stdClass
     */
    private function _parseTypeAndScope($type)
    {
        $pattern = '//';
    }
}