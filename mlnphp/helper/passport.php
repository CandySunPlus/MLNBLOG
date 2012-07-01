<?php

namespace MLNPHP\Helper;

/**
 * 用户通行证基类
 * 
 * @package MLNPHP
 */
abstract class Passport
{
    public $userModel;
    public $userEntity;

    public function __construct()
    {
        $this->userModel = $this->getUserModel();
        $this->userEntity = null;
        if (isset($_SESSION[$this->getSessionKey()])) {
            $this->userEntity = $this->getLoginedUser();
        }
    }

    /**
     * 获取登录的用户实体
     * 
     * @return Entity
     */
    public function getLoginedUser()
    {
        $sessionKey = $this->getSessionKey();
        if ($this->userEntity == null) {
            $userId = isset($_SESSION[$sessionKey]['id']) ? $_SESSION[$sessionKey]['id'] : -1;
            if ($userId > 0) {
                return call_user_func($this->userModel . '::get', $userId);
            } else {
                return null;
            }
        } 
        return $this->userEntity;
    }

    /**
     * 获取Session会话标识
     * @return string
     */
    protected function getSessionKey()
    {
        static $key = null;
        if (null == $key) {
            $key = md5('MLNPHP');
        }
        return $key;
    }

    /**
     * 登录
     * 
     * @param string $account 账号
     * @param string $password 密码 
     * @param array $extras 其他信息
     * 
     * @return void
     */
    public function login($account, $password, $extras = array())
    {

    }

    /**
     * 登出
     * 
     * @return void
     */
    public function logout()
    {

    }

    /**
     * 注册
     * 
     * @param string $account 账号
     * @param string $password 密码
     * @param string $repeatPassword 重复密码
     * @param array $extras 其他信息
     * 
     * @return void
     */
    public function register($account, $password, $repeatPassword, $extras = array())
    {

    }

    /**
     * 修改密码
     * 
     * @param string $oldPassword 旧密码
     * @param string $password 新密码
     * @param string $repeatPassword 重复密码
     * 
     * @return void
     */
    public function modifyPassword($oldPassword, $password, $repeatPassword)
    {

    }

    /**
     * 加密密码
     * 
     * @param string $password 密码
     * @param string $salt 干扰码
     * 
     * @return string
     */
    public function encryptPassword($password, $salt)
    {
        return md5($password . $salt);
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
        return true;
    }

    /**
     * 用户模型获取方法
     * 
     * @return Model
     */
    abstract protected function getUserModel();

}