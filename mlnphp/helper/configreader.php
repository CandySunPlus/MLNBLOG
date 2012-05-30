<?php
namespace MLNPHP\Helper;

use \MLNPHP\Helper\ArrayMap;
use \Exception;

/**
 * 配置文件读取类
 * 
 * @package MLNPHP
 */
class ConfigReader
{
	/**
	 * 获取应用配置文件
	 * 
	 * @return ArrayMap
	 */
	public static function get()
	{
		$config = require self::_getConfigPath();
		return new ArrayMap($config);
	}

	/**
	 * 获取配置文件路径
	 * 
	 * @return string
	 */
	private static function _getConfigPath()
	{
		$filePath = APP_PATH . DS . 'config.php';
		if (!file_exists($filePath)) {
			throw new Exception('未找到应用配置文件！');
		}
		return APP_PATH . DS . 'config.php';
	}

}