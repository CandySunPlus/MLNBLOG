<?php

namespace APP\Controller\Abstraction;

use \MLNPHP\System\ControllerBase;

abstract class AdminController extends ControllerBase
{
    protected function initialize()
    {
        session_start();
        
        if (!$this->validate()) {
            exit;
        }
    }

    protected function destory()
    {

    }

    abstract protected function validate();
}