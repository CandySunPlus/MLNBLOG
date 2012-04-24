<?php
namespace MLNPHP\System;

use \MLNPHP\System\Route;
use \MLNPHP\MLNPHP;
use \Exception;
/**
 * 请求分发器
 * 
 * @package MLNPHP
 */
class Dispatch
{
	private $_route;
	private $_controller;
	private $_action;
	private $_params;
	private $_app;

	public function __construct($router = array())
	{
		$this->_route = new Route($router, getenv('PATH_INFO'));
		$this->_app = MLNPHP::getApplication();
	}

	/**
	 * 执行分发
	 * 
	 * @return void
	 */
	public function run()
	{
		list($this->_controller, $this->_action, $this->_params) = array_values($this->_route->parse());

		$realCAP = $this->getRealCAP($this->_controller, $this->_action);

		$controllerCls = $realCAP['controllerCls'];
		$action = $realCAP['action'];

		if (class_exists($controllerCls) && method_exists($controllerCls, $action)) {
			$this->runCAP($controllerCls, $action, $this->_params);
		} else {
			throw new Exception('Action not exists');
		}
	}

	/**
	 * 获取完整命名空间的控制器类名和动作
	 * 
	 * @param string $controller 控制器
	 * @param string $action 动作
	 * 
	 * @return array
	 */
	public function getRealCAP($controller, $action) {
		$controllerCls = $this->_app->conf->path['controller'] . '\\' . ucfirst($controller);
		$action = $action . 'Action';
		return array(
			'controllerCls' => $controllerCls,
			'action' => $action
		);
	}

	/**
	 * 运行控制器的相关动作
	 * 
	 * @param Object $controllerCls 控制器类
	 * @param string $action 动作
	 * @param array $params 参数
	 * 
	 * @return void
	 */
	public function runCAP($controllerCls, $action, $params)
	{	
		try {
			$controllerInstance =  new $controllerCls($params);
			$controllerInstance->run($action);
		} catch (Exception $e) {
			debug($e);
			header('HTTP/1.0 404 Not Found');
		}
		
	}
}
