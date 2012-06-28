<?php
namespace MLNPHP\Helper;

use \MLNPHP\System\View;
use \MLNPHP\Helper\Notice;
/**
 * Http response 类
 *
 * @author sunfengming
 */
class Response {

    /**
     * 设置头
     * 
     * @param string $key 属性名
     * @param string $value 属性值
     * 
     * @return void
     */
    public static function setHeader($key, $value)
    {
        header(sprintf('%s:%s', $key, $value));
    }
    
    /**
     * 设置文档类型 
     * 
     * @param string $contentType 文档类型
     * 
     * @return void
     */
    public static function setContentType($contentType)
    {
        self::setHeader('Content-type', $contentType);
    }
    
    /**
     * 输出文件
     * 
     * @param mixed $arg 要输出的内容
     * @param string $contentType 输出的类型
     * 
     * @return void
     */
    public static function outputFile($arg, $contentType)
    {
        self::setContentType($contentType);
        
        echo $arg;
    }

    /**
     * 404 NOT FOUND
     * 
     * @return void
     */
    public static function notFound()
    {
        $view = new View();
        self::output($view->render('404', View::SYS));
    }
    
    /**
     * 输出HTML
     * 
     * @param mixed $arg 要输出的内容
     * @param string $contentType 输出的类型
     * 
     * @return void
     */
    public static function output($arg)
    {
        $elapsedTime = (microtime(true) - START_TIME) * 1000;
        $memory = memory_get_usage() / 1024 / 1024;
        $arg .= "\n" . 
            sprintf(
                "<!-- 共消耗时间 %.2f ms, 内存占用 %.2f mb, 本程序由 MLNPHP 框架提供动力。 -->", 
                $elapsedTime, 
                $memory
            );
        self::outputFile($arg, 'text/html; charset=utf-8');
    }

    /**
     * 转向
     * 
     * @param string $url 地址
     * @param mixed $msg 消息
     * @param string $level 消息等级
     * 
     * @return void
     */
    public static function redirect($url, $msg, $level)
    {
        Notice::add($msg, $level);
        header('Location:' . $url);
    }
}

?>
