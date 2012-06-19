<?php
namespace APP\Controller;

use \APP\Controller\Abstraction\AdminController;
use \APP\Library\Visitor;

class Index extends AdminController
{
    protected function validate()
    {
        $visitor = Visitor::getInstance();
        if ($visitor->isLogin()) {
            return true;
        }
        return false;
    }

    public function showAction()
    {
        
    }
}