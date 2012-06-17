<?php
namespace MLNPHP\System;

use \MLNPHP\System\Dispatch;
use \MLNPHP\Helper\Response;
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
	public $dispatch;

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
		
        date_default_timezone_set($this->conf->timezone);
        if (!$this->conf->debug) {
        	error_reporting(~E_ALL);
        }
	}

	/**
	 * 获取控制器路径
	 * 
	 * @return string
	 */
	private function _getControllerPath()
	{
		$controllerPath = empty($this->conf->path->controller) ? 
			null :
			$this->conf->path->controller;	
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
		$modelPath = empty($this->conf->path->model) ? 
			null :
			$this->conf->path->model;
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
		$templatePath = empty($this->conf->path->template) ? 
			null :
			$this->conf->path->template;
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
		if (!isset($this->conf->router)) {
			$this->conf->put('router', array());
		}

		$this->dispatch = new Dispatch($this->conf->router);
		
		try {			
			$this->dispatch->run();	
		} catch (Exception $e) {
			if ($e->getCode() == 404) {
				$this->notFound();
			} else {
				throw $e;
				
			}
		}
	}

	/**
	 * 404 NOT FOUND
	 * 
	 * @return void
	 */
	public function notFound()
	{
		try {
			$this->runCustom404();
        } catch (Exception $e) {
        	Response::notFound();
        }
	}

	/**
	 * Custom 404 NOT FOUND
	 * 
	 * @return void
	 */
	public function runCustom404()
	{
		$controller = $this->conf->page->p404->controller;
		$action = $this->conf->page->p404->action;
		$params = $this->conf->page->p404->params;

		$realCAP = $this->dispatch->getRealCAP($controller, $action);
		$controllerCls = $realCAP['controllerCls'];
		$action = $realCAP['action'];
		header('HTTP/1.0 404 File Not Found');
		$this->dispatch->runCAP($controllerCls, $action, $params);
	}
}