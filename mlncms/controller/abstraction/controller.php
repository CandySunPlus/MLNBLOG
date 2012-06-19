<?php

namespace APP\Controller\Abstraction;

use MLNPHP\System\ControllerBase;


abstract class Controller extends ControllerBase
{
    protected function initialize()
    {
        if (!$this->validate()) {
            exit;
        }
    }

    protected function destory()
    {

    }

    abstract protected function validate();
}