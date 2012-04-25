<?php

/**
 * MLNPHP框架核心类
 * 
 * @package MLNPHP
 */

namespace MLNPHP;

use \MLNPHP\System\HttpApplication;
use \MLNPHP\Helper\ChromePhp;
use \Exception;

class MLNPHP
{
    private static $_application;
    private static $_requireClasses;

    /**
     * 初始化框架
     * 
     * @return void
     */
    public static function initialize()
    {        
        self::$_requireClasses = array();
        spl_autoload_register('self::autoload');
        
        set_error_handler(array('\\MLNPHP\\System\\Error', 'handler'));
        register_shutdown_function(array('\\MLNPHP\\System\\Error', 'fatal'));
        
    }

    /**
     * 获取应用的实例
     * 
     * @param mixed $config 应用的配制文件
     * 
     * @return mixed
     */
    public static function getApplication($config = null)
    {
        
        if (empty(self::$_application)) {
            self::$_application = new HttpApplication($config);
        }

        return self::$_application;
    }

    /**
     * 类文件自动加载
     * @param string $name 带命名空间的类名
     * @return void
     */
    public static function autoload($name)
    {
        if (isset(self::$_requireClasses[$name])) {
            return self::$_requireClasses[$name];
        }

        $clsInfo = explode('\\', $name);
        $clsFlags = array_shift($clsInfo);
        $clsFileName = strtolower(array_pop($clsInfo)) . '.php';

        $clsPath = '';
        foreach ($clsInfo as $path) {
            $clsPath .= strtolower($path) . DS;
        }

        $preFix = self::getPrefix($clsFlags);

        $clsRealPath = $preFix . DS . $clsPath . $clsFileName;

        if (file_exists($clsRealPath)) {
            self::$_requireClasses[$name] = $clsRealPath;
            require $clsRealPath;
        } else {
            throw new Exception(sprintf("缺少依赖的类文件 %s", $name));            
        }
        
    }

    /**
     * 通过命名空间前缀获取真实路径前缀
     * 
     * @param string $clsFlags 命名空间前缀
     * 
     * @return string
     */
    public static function getPrefix($clsFlags)
    {
        switch ($clsFlags) {
            case 'MLNPHP':
                $preFix = F_PATH;
                break;
            case 'APP':
                $preFix = APP_PATH;
                break;
            case 'ROOT':
                $preFix = ROOT_PATH;
                break;
            default:
                $preFix = F_PATH;
                break;
        }
        return $preFix;
    }

    /**
     * 站点调试输出
     * 
     * @return void
     */
    public static function debug()
    {
        $args = func_get_args();
        ChromePhp::log($args);
    }
}
