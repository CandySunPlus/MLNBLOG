<?php
namespace MLNPHP\Helper;

use \Exception;

/**
 * 配置文件读取类
 * 
 * @package MLNPHP
 */
class ConfigReader
{
	private $_config;

	private function __construct($config)
	{
		$this->_config = $config;
	}

	/**
	 * 获取配置节点属性
	 * 
	 * @param string $name 节点名称
	 * 
	 * @return mixed
	 */
	public function __get($name)
	{
		if (isset($this->_config[$name])) {
			return $this->_config[$name];
		}

		throw new Exception(
			sprintf('未找到配置属性 %s ！', $name)
		);
	}

	/**
	 * 获取应用配置文件
	 * 
	 * @return object
	 */
	public static function get()
	{
		$config = require self::_getConfigPath();
		return new self($config);
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