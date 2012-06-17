<?php
namespace MLNPHP\Helper;

use \ArrayObject;
use \Exception;

/**
 * 数组对象映射
 * 
 * @package MLNPHP
 */
class ArrayMap extends ArrayObject
{

    public function __construct($array = array())
    {
        foreach ($array as &$value){
            if(is_array($value) && isset($value)){
                $value = new self($value);
            }
        }

        parent::__construct($array);
    }

    /**
     * 取值
     * 
     * @param string $index 索引
     * 
     * @return mixed
     */
    public function __get($index){
        if ($this->offsetExists($index)) {
            return $this->offsetGet($index);
        } else {
            throw new Exception('undefined index in arraymap');
        }
    }

    /**
     * 赋值
     * 
     * @param string $index 索引
     * @param mixed $value 值
     * 
     * @return void
     */
    public function __set($index, $value){
        if (is_array($value) && isset($value)) {
            $value = new self($value);
        }
        $this->offsetSet($index, $value);
    }

    /**
     * 是否存在
     * 
     * @param string $index 索引
     * 
     * @return bool
     */
    public function __isset($index){
        return $this->offsetExists($index);
    }

    /**
     * 删除
     * 
     * @param string $index 索引
     * 
     * @return void
     */
    public function __unset($index){
        $this->offsetUnset($index);
    }

    /**
     * 转换为数组类型
     * 
     * @return array
     */
    public function toArray(){
        $array = $this->getArrayCopy();
        foreach ($array as &$value){
            if ($value instanceof self) {
                $value = $value->toArray();
            }
        }
        return $array;
    }

    /**
     * 打印成字符
     * 
     * @return string
     */
    public function __toString(){
        return var_export($this->toArray(), true);
    }


    /**
     * 根据索引赋值
     * 
     * @param string $index 索引
     * @param mixed $value 值
     * 
     * @return void
     */
    public function put($index, $value){
        if (is_array($value) && isset($value)) {
            $value = new self($value);
        }
        $this->offsetSet($index, $value);
    }

    /**
     * 根据索引取值
     * 
     * @param string $index 索引
     * 
     * @return mixed
     */
    public function get($index){
        return $this->offsetGet($index);
    }
}