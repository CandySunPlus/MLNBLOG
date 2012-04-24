<?php
namespace MLNPHP\System;

use \MLNPHP\Helper\Request;
/**
 * 控制器基类
 * 
 * @package MLNPHP
 */
abstract class ControllerBase
{
	public $request;

	public function __construct($params)
	{
		$this->request = Request::getInstance();
		$this->request->set($params, Request::GET);	
	}

	/**
	 * 运行此控制器的命令
	 * 
	 * @param string $action 命令
	 * 
	 * @return void
	 */
	public function run($action) 
	{
		$init = $this->initialize(get_called_class(), $action);
		$this->$action();
		$this->destory(get_called_class(), $action);
	}

	/**
	 * 在调用前
	 * 
	 * @return void
	 */
	abstract protected function initialize($controllerCls, $action);

	/**
	 * 在调用后
	 * 
	 * @return void
	 */
	abstract protected function destory($controllerCls, $action);
}