<?php
namespace APP\Controller;

use \MLNPHP\System\ControllerBase;
use \MLNPHP\Helper\Notice;
use \MLNPHP\Helper\Response;
use \MLNPHP\Helper\Form;
use \APP\Library\Visitor;
use \Exception;

class Profile extends ControllerBase
{
    public function loginAction()
    {
        $notices = Notice::getAll(true);
        $this->view->assign('notices', $notices);     
        $this->view->assign('loginToken', Form::getFormToken('login'));
        Response::output($this->view->render('login'));
    }

    public function doLoginAction()
    {
        $formToken = $this->request->post('formtoken');
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        try {
            Visitor::getInstance()->getPassport()->login($username, $password, array('formToken' => $formToken));
        } catch (Exception $e) {
            Response::redirect('/admin/login', $e->getMessage(), Notice::ERROR);
            return false;
        }
        Response::redirect('/admin/index', '登录成功！', Notice::NOTICE);
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