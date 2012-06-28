<?php
namespace MLNPHP\Helper;

/**
 * 表单类
 *
 * @author sunfengming
 */
class Form
{
    /**
     * 创建或获取一个表单唯一生命码
     * 
     * @param string $formId 表单唯一标识 
     * 
     * @return string
     */
    public static function getFormToken($formId)
    {        
        if (!isset($_SESSION['FORM_TOKEN'][$formId]) {
            $uniqid = md5(uniqid($formId));
            $_SESSION['FORM_TOKEN'][$formId] = $uniqid;
        }
        return $_SESSION['FORM_TOKEN'][$formId];
    }

    /**
     * 对比表单生命唯一码
     * 
     * @param string $formId 表单唯一码
     * @param string $token 表单生命唯一码
     * 
     * @return bool
     */
    public static function compareFormToken($formId, $token)
    {
        if (isset($_SESSION['FORM_TOKEN'][$formId])) {
            if ($token == $_SESSION['FORM_TOKEN'][$formId]) {
                return true;
            }
            unset($_SESSION['FORM_TOKEN'][$formId]);
        }
        return false;
    }
}