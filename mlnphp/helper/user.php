<?php

namespace MLNPHP\Helper;

/**
 * 用户基类
 * 
 * @package MLNPHP
 */
abstract class User
{
    protected $passport = null;
    protected $entity = null;

    /**
     * 获取用户实例
     * 
     * @return User
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null == $instance) {
            $instance = new static;
        }
        return $instance;
    }

    /**
     * 构造
     * 
     * @return void
     */
    protected function __construct()
    {
        $this->passport = $this->createPassport();
        $this->entity = $this->passport->getLoginedUser();
    }

    /**
     * 获取通行证
     * 
     * @return Passport
     */
    public function getPassport()
    {
        return $this->passport;
    }

    /**
     * 是否已经登录
     * 
     * @return bool
     */
    public function isLogin()
    {
        if ($this->entity == null) {
            return false;
        }
        return true;
    }

    /**
     * 用户是否有权限
     * 
     * @param string $controller 控制器
     * @param string $action 动作
     * 
     * @return bool
     */
    public function hasPrivilege($controller, $action) {
        return $this->passport->hasPrivilege($controller, $action);
    }

    /**
     * 创建通行证
     * 
     * @return Passport
     */
    abstract protected function createPassport();

}