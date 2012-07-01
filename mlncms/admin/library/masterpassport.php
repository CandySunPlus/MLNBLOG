<?php
namespace APP\Library;

use \MLNPHP\Helper\Passport;
use \MLNPHP\Helper\Form;
use \Exception;

class MasterPassport extends Passport
{
    protected function getUserModel()
    {
        return model('Masters');
    } 

    public function login($account, $password, $extras = array())
    {
        $formToken = $extras['formToken'];
        $sessionKey = $this->getSessionKey();
        if (Form::compareFormToken('login', $formToken)) {
            $master = call_user_func($this->getUserModel() . '::getUserByName', $account);
            if (empty($master)) {
                throw new Exception("用户不存在！");
            } else {
                //TODO 密码
            }
            $_SESSION[$sessionKey]['id'] = 1;
        } else {
            throw new Exception("表单已失效！");
            
        }
    } 
}