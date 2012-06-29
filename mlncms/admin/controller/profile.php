<?php
namespace APP\Controller;

use \MLNPHP\System\ControllerBase;
use \MLNPHP\Helper\Notice;
use \MLNPHP\Helper\Response;
use \APP\Library\Visitor;

class Profile extends ControllerBase
{
    public function loginAction()
    {
        $notices = Notice::getAll(true);
        $this->view->assign('notices', $notices);     
        Response::output($this->view->render('login'));
    }

    protected function initialize()
    {
        session_start();  
    }

    protected function destory()
    {
        //...
    }
}