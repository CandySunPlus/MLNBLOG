<?php

namespace APP\Controller\Abstraction;

use \MLNPHP\System\ControllerBase;
use \APP\Library\Visitor;

abstract class AdminController extends ControllerBase
{
    /**
     * 控制器初始
     * 
     * @return void
     */
    protected function initialize()
    {
        session_start();        
        if (!$this->validate()) {
            exit;
        }
    }

    /**
     * 控制器析构
     * 
     * @return void
     */
    protected function destory()
    {

    }

    /**
     * 验证登录
     * 
     * @return bool
     */
    protected function validate()
    {
        $visitor = Visitor::getInstance();
        if (!$visitor->isLogin()) {
            return false;
        }
        return $this->validatePrivilege();
    }

    /**
     * 验证权限
     * 
     * @param string $controller 控制器 
     * @param string $action 动作
     * 
     * @return bool
     */
    protected function validatePrivilege($controller, $action)
    {
        return true;
    }
}