<?php

namespace APP\Controller\Abstraction;

use MLNPHP\System\ControllerBase;


abstract class Controller extends ControllerBase
{
    protected function initialize()
    {
        if (!$this->verification()) {
            exit;
        }
    }

    protected function destory()
    {

    }

    abstract protected function verification();
}