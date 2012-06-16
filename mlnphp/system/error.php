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
            ob_get_clean();
            if (~E_ALL === error_reporting()) {
                return true;
            }
            self::header();
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
        $view->assign('exception', $e);
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
        self::header();
        if (0 === (error_reporting() & $code)) {
            return true;
        }
        $view = new View();
        $view->assign('code', $code)
            ->assign('error', $error)
            ->assign('file', $file)
            ->assign('line', $line);
        $page = $view->render('error', View::SYS);
        Response::output($page);
        
        return true;
    }

    /**
     * Fetch and HTML highlight serveral lines of a file.
     *
     * @param string $file to open
     * @param integer $number of line to highlight
     * @param integer $padding of lines on both side
     * 
     * @return string
    */
    public static function source($file, $number, $padding = 5)
    {
        // Get lines from file
        $lines = array_slice(file($file), $number-$padding-1, $padding*2+1, 1);

        $html = '';
        foreach($lines as $i => $line)
        {
            $html .= '<b>' . sprintf('%' . mb_strlen($number + $padding) . 'd', $i + 1) . '</b> '
                . ($i + 1 == $number ? '<em>' . h($line) . '</em>' : h($line));
        }
        return $html;
    }


    /**
     * Fetch a backtrace of the code
     *
     * @param int $offset to start from
     * @param int $limit of levels to collect
     * 
     * @return array
     */
    public static function backtrace($offset, $limit = 5)
    {
        $trace = array_slice(debug_backtrace(), $offset, $limit);

        foreach($trace as $i => &$v)
        {
            if( ! isset($v['file']))
            {
                unset($trace[$i]);
                continue;
            }
            $v['source'] = self::source($v['file'], $v['line']);
        }

        return $trace;
    }
}

