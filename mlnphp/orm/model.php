<?php
namespace MLNPHP\ORM;

use \MLNPHP\MLNPHP;
use \MLNPHP\ORM\SQLBuilder;
use \MLNPHP\ORM\Adapter\Mysql\Mysql;
use \Exception;

/**
 * 模型基类
 * 
 * @package MLNPHP
 */
abstract class Model
{
    public static $dbType;
    public static $primaryKey;
    public static $fields;
    protected static $table;
    protected static $adapter;
    protected static $dataType;
    protected $data;
    protected $sqlBuilder;

    const MYSQL = '\\MLNPHP\\ORM\\Adapter\\Mysql\\Mysql';

    private function __construct($id = null)
    {
        $this->_init();
        $this->data = array();
        if (null == $id) {       
            $this->_fillData();
            unset($this->data[static::$primaryKey]);
        } elseif (is_numeric($id)) {
            $this->data[static::$primaryKey] = $id;
            $data = current($this->select('*')->where(static::$primaryKey, '=', $id)->fetch());
            if (false === $data) {
                throw new Exception("无法获取指定主键实体");
            }
            $this->_fillData($data);
        } else {
            throw new Exception("无法获取指定主键实体");            
        }        
    }

    /**
     * 初始化模型
     * 
     * @return void
     */
    private function _init()
    {
        $dbConfigName = MLNPHP::getApplication()->conf->db['use'];
        $model = explode('\\', get_called_class());
        $tableName = strtolower(array_pop($model));
        static::$adapter = call_user_func(static::$dbType . '::getInstance', $dbConfigName);        
        static::$dataType = call_user_func(static::$dbType . '::getDataType');
        static::$table = static::$adapter->tables[$tableName];
        static::$primaryKey = static::$table->primaryKey;
        $this->sqlBuilder = new SQLBuilder(static::$table);
    }

    /**
     * 获取指定主键的实体
     * 
     * @param int $id 主键
     * 
     * @return Entity
     */
    public static function get($id)
    {
        return new static($id);
    }

    /**
     * 新建实体
     * 
     * @return Entity
     */
    public static function create()
    {
        return new static();
    }

    /**
     * 设置实体的内容
     * 
     * @param string $field 字段名
     * @param mixed $value 字段的内容
     * 
     * @return void
     */
    public function __set($field, $value)
    {
        $this->data[$field] = $value;
    }

    /**
     * 填充实体数据
     * 
     * @param array $data 预填充数据
     * 
     * @return void
     */
    private function _fillData($data = null)
    {
        foreach (static::$table->fields as $fieldName => $field) {
            if (null === $data) {
                $this->data[$fieldName] = $field->default;
            } else {
                $this->data[$fieldName] = $data[$fieldName];
            }
        }
        
    }

    /**
     * 验证字段赋值是否合法
     * 
     * @param string $field 字段名
     * @param mixed $value 字段内容
     * 
     * @return void
     */
    private function _validate($field, $value)
    {
        if (!isset(static::$table->fields[$field])) {
            throw new Exception(sprintf("您所指定的字段 %s 不存在", $field));            
        }

        $originField = static::$table->fields[$field];
        if ($originField->null && empty($value)) {
            throw new Exception(sprintf("您所指定的字段 %s 不能为空", $field)); 
        }

        switch (static::$dataType[$originField->type]) {
            case 'integer':
                $this->_validateInteger($value, $originField->scope);
                break;
            case 'string':
                $this->_validateString($value, $originField->scope);
                break;
            default:
                throw new Exception("字段类型不合法");
                break;
        }
    }

    /**
     * 验证数字类型
     * 
     * @param mixed $value 需要验证的
     * @param array $scope 验证的规则
     * 
     * @return void
     */
    private function _validateInteger($value, $scope)
    {
        if (!is_integer((int)$value)) {
            throw new Exception(sprintf("您所指定的字段的值 %s 不符合字段类型 Integer", $value));
        }

        if (null !== $scope) {
            
        }
    }

    /**
     * 验证字符串类型
     * 
     * @param mixed $value 需要验证的
     * @param array $scope 验证的规则
     * 
     * @return void
     */
    private function _validateString($value, $scope)
    {
        if (!is_string((string)$value)) {
            throw new Exception(sprintf("您所指定的字段的值 %s 不符合字段类型 String", $value));
        }

        if (null !== $scope) {
            $len = mb_strlen($value); 
            if ($len > $scope[0]) {
                throw new Exception("您所指定的字段的值超出范围");
            }
        }
    }

    /**
     * 取实体指定字段内容
     * 
     * @param string $field 字段名
     * 
     * @return mixed
     */
    public function __get($field)
    {
        if (!isset($this->data[$field])) {
            throw new Exception(sprintf("您所指定的字段 %s 不存在", $field));
        }

        return $this->data[$field];
    }

    /**
     * 保存实体
     * 
     * @return void
     */
    public function save()
    {
        //debug($this->sqlBuilder->update(array('id'=>1, 'title'=>'s'), "id = '1'"));
        foreach ($this->data as $field => $value) {
            $this->_validate($field, $value);
        }

        if (isset($this->data[static::$primaryKey])) {
            $where = static::$primaryKey . '=' . "'" . $this->data[static::$primaryKey] . "'";
            $sql = $this->sqlBuilder->update($this->data, $where);
            static::$adapter->query($sql);
        } else {
            $sql = $this->sqlBuilder->insert($this->data);
            static::$adapter->query($sql);
            $this->data[static::$primaryKey] = static::$adapter->insertId();
        }
        return $this->data[static::$primaryKey];
    }

    /**
     * 删除相关实体
     * 
     * @return void
     */
    public function delete()
    {
        if (null !== $this->data[static::$primaryKey]) {
            $id = $this->data[static::$primaryKey];
        }
    } 
    
    /**
     * 获取执行结果
     * 
     * @return array 
     */
    public function fetch()
    {
        $sql = (string)$this->sqlBuilder;
        $rs = static::$adapter->query($sql);
        return static::$adapter->fetch($rs);
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
        call_user_func_array(array($this->sqlBuilder, $funcname), $args);
        return $this;
    }
}