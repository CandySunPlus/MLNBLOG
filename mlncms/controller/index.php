<?php
namespace APP\Controller;

use \APP\Controller\Abstraction\Controller;
use \MLNPHP\Helper\Response;

class Index extends Controller
{
    public function showAction()
    { 
        Response::output($this->view->render('index'));
    }
    
    protected function validate()
    {
        
        return true;
    }
}