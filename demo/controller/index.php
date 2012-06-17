<?php
namespace APP\Controller;

use \APP\Controller\Abstraction\Controller;
use \MLNPHP\Helper\Response;

class Index extends Controller
{
    public function showAction()
    { 
        $author = 'Fengming Sun';
        $this->view->assign('author', $author);
        Response::output($this->view->render('index'));
    }
    
    protected function verification()
    {
        
        return true;
    }
}