<?php
namespace MLNPHP\System;

use \MLNPHP\System\Dispatch;
use \Exception;

/**
 * Http应用类
 * 
 * @package MLNPHP
 */
class HttpApplication
{
	public $conf;
	public $controllerPath;
	public $modelPath;
	public $templatePath;

	const defaultController = 'index';
	const defaultAction = 'show';
	
	/**
	 * 应用初始化
	 * 
	 * @param ConfigReader $config 配置
	 * 
	 * @return void
	 */
	public function __construct($config)
	{
		$this->conf = $config;
		$this->controllerPath = $this->_getControllerPath();
		$this->modelPath = $this->_getControllerPath();
		$this->templatePath = $this->_getTemplatePath();
	}

	/**
	 * 获取控制器路径
	 * 
	 * @return string
	 */
	private function _getControllerPath()
	{
		$controllerPath = empty($this->conf->path['controller']) ? 
			null :
			$this->conf->path['controller'];	
		if (null == $controllerPath) {
			throw new Exception('控制器目录未配置！');
		}
		return $controllerPath;	
	}

	/**
	 * 获取模型路径
	 * 
	 * @return string
	 */
	private function _getModelPath()
	{
		$modelPath = empty($this->conf->path['model']) ? 
			null :
			$this->conf->path['model'];
		if (null == $modelPath) {
			throw new Exception('模型目录未配置！');
		}
		return $modelPath;
	}

	/**
	 * 获取视图路径
	 * 
	 * @return string
	 */
	private function _getTemplatePath()
	{
		$templatePath = empty($this->conf->path['template']) ? 
			null :
			$this->conf->path['template'];
		if (null == $templatePath) {
			throw new Exception('视图目录未配置！');
		}
		return $templatePath;
	}

	/**
	 * 运行应用
	 * 
	 * @return void
	 */
	public function run()
	{
		$dispatch = new Dispatch($this->conf->router);
		$dispatch->run();
	}
}