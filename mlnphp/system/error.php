<?php
namespace MLNPHP\System;

use \MLNPHP\System\View;
use \MLNPHP\Helper\Response;
use \ErrorException, \Exception;
/**
 * 错误异常处理类
 *
 * @author sunfengming
 */
class Error {
    /**
     * 500错误文件头
     * 
     * @return void 
     */
    public static function header()
    {
        header('HTTP/1.0 500 Internal Server Error');
    }
    
    /**
     * 系统级别错误处理
     * 
     * @return void 
     */
    public static function fatal()
    {
        if (error_get_last()) {
            $e = error_get_last();
            Error::exception(new \ErrorException($e['message'], $e['type'], 0, $e['file'], $e['line']));
        }
    }
    
    /**
     * 异常处理函数
     * 
     * @param Exception $e 异常
     * 
     * @retun void 
     */
    public static function exception($e)
    {
        $view = new View();
        $page = $view->render('exception', View::SYS);
        Response::output($page);
        exit;
    }
    
    /**
     * 错误处理
     * 
     * @param int $code 错误编号
     * @param string $error 错误信息
     * @param string $file 错误文件
     * @param int $line 错误行号
     * 
     * @return boolean 
     */
    public static function handler($code, $error, $file = 0, $line = 0)
    {
        if (0 === (error_reporting() & $code)) {
            return true;
        }
        $view = new View();
        $page = $view->render('error', View::SYS);
        Response::output($page);
        return true;
    }
}

