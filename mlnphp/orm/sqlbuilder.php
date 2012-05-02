<?php
namespace MLNPHP\ORM;

use \Exception;
/**
 * SQL生成
 * 
 * @package MLNPHP
 */
class SQLBuilder
{
    public $sql;
   
    protected $table;
    protected $select;
    protected $where;
    protected $orderBy;
    protected $groupBy;
    protected $limit;

    public function __construct($table)
    {
        $this->table = $table;
        $this->select = array();
        $this->where = array();
        $this->orderBy = array();
        $this->groupBy = '';
        $this->limit =  array();
    }
    
    /**
     * 选取字段
     * 
     * @return $this;
     */
    public function select()
    {
        $fields = func_get_args();
        $this->select = array_combine($fields, $fields);
       
        return $this;
    }
    
    /**
     * 选取字段
     * 
     * @param string $fields 字段名，多个用,分割 
     * 
     * @return $this;
     */
    public function alias($fields, $alias)
    {
        $this->select[$fields] = $alias;
        return $this;
    }
    
    /**
     * 逻辑判断
     * 
     * @param string $operator 逻辑
     * @param string $field 字段名
     * @param string $compare 比较运算符
     * @param mixed $value 值
     * 
     * @return $this
     */
    private function _where($operator, $field, $compare, $value)
    {
        $compare = strtoupper($compare);
        $allowed = array('=', '>=', '<=', '>', '<', '<>', 'IN', 'LIKE', 'NOT IN', 'BETWEEN');

        if (!in_array($compare, $allowed)) {
            throw new Exception('不支持的比较运算：' . $compare);
        }
        
        /**
         * 对所有条件进行处理，避免SQL注入
         */
        if (is_array($value)) {
            foreach ($value AS $key => $val) {
                $value[$key] = addslashes($val);
            }
        } else {
            $value = addslashes($value);
        }

        switch ($compare) {
        case 'IN':
            if (!is_array($value)) {
                throw new Exception('用于 IN 比较的必须是数组');
            }
            $value = "('" . implode("','", $value) . "')";
            break;
        case 'NOT IN':
            if (!is_array($value)) {
                throw new Exception('用于 NOT IN 比较的必须是数组');
            }
            $value = "('" . implode("','", $value) . "')";
            break;
        case 'BETWEEN':
            if (!is_array($value) || count($value) != 2) {
                throw new Exception('用于 BETWEEN 比较的必须是数组');
            }
            $value = "'{$value[0]}' AND '{$value[1]}'";
            break;
        default:
            $value = "'" . $value . "'";
            break;
        }
        
        if (count($this->where) > 0) {
            $this->where[] = $operator;
        }
        
        $this->where[] = array($field, $compare, $value);
        return $this;
    }
    
    /**
     * 逻辑判断
     * 
     * @param string $field 字段名
     * @param string $compare 比较运算符
     * @param mixed $value 值
     * 
     * @return $this
     */
    public function where($field, $compare, $value)
    {
        $this->_where('AND', $field, $compare, $value);
        return $this;
    }
    
    /**
     * 逻辑判断
     * 
     * @param string $field 字段名
     * @param string $compare 比较运算符
     * @param mixed $value 值
     * 
     * @return $this
     */
    public function orWhere($field, $compare, $value)
    {
        $this->_where('OR', $field, $compare, $value);
        return $this;
    }
    
    /**
     * 分组
     * 
     * @param string $field 字段名
     * 
     * @return $this
     */
    public function groupBy($field)
    {
        if (!in_array($field, $this->select)) {
            throw new Exception(sprintf('字段 %s 不存在', $field));
        }
        $this->groupBy = $field;
        return $this;
    }
    
    /**
     * 排序
     * 
     * @param string $field 排序字段
     * @param string $orderType 排序方法
     * 
     * @return $this
     */
    public function orderBy($field, $orderType = 'DESC')
    {
        if (!in_array($field, $this->select)) {
            throw new Exception(sprintf('字段 %s 不存在', $field));
        }
        $this->orderBy[$field] = $orderType;
        return $this;
    }
    
    /**
     * 常第offset显示limit条
     * 
     * @param int $limit 条数
     * @param int $offset 起始条数
     * 
     * @return $this
     */
    public function limit($limit, $offset = 0)
    {
        $this->limit = array($offset, $limit);
        return $this;
    }
    
    /**
     * SQL输出
     * 
     * @return string 
     */
    public function __toString()
    {
        $select = $this->_getSelect();
        $where = $this->_getWhere();
        $groupBy = empty($this->groupBy) ? '' : 'GROUP BY ' . $this->groupBy;
        $orderBy = $this->_getOrderBy();
        $limit = $this->_getlimit();
        
        $sql = sprintf('SELECT %s FROM %s %s %s %s %s', $select, $this->table->tableName, $where, $groupBy, $orderBy, $limit);
        return $sql;
    }
    
    /**
     * 获取select 
     * 
     * @return string
     */
    private function _getSelect()
    {
        foreach ($this->select as $field => &$alias) {
            if ($field != $alias) {
                $alias = $field . ' AS ' . $alias;
            }
        }
        return implode(', ', $this->select);
    }
    
    /**
     * 获取where
     * 
     * @return string
     */
    private function _getWhere()
    {
        $where = '';
        foreach ($this->where as $value) {
            if (!is_array($value)) {
                $where .= ' ' .$value . ' ';
            } else {
                $where .= $value[0] . $value[1] . $value[2];
            }            
        }
        return 'WHERE ' . $where;
    }
    
    /**
     * 获取orderby
     * 
     * @return string
     */
    private function _getOrderBy()
    {
        $orders = array();
        foreach ($this->orderBy as $field => $orderType) {
            $orders[] = $field . ' ' . $orderType;
        }
        if (!empty($orders)) {
            return 'ORDER BY ' . implode(',', $orders);
        }
    }
    
    /**
     * 获取limit
     * 
     * @return string
     */
    private function _getlimit()
    {
        if (!empty($this->limit)) {
            return 'LIMIT ' . $this->limit[0] . ', ' . $this->limit[1];
        }
    }
}