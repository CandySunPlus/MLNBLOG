<?php
namespace MLNPHP\System;

use \MLNPHP\System\Route;
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

	public function __construct($router = array())
	{
		$this->_route = new Route($router, getenv('PATH_INFO'));
	}

	/**
	 * 执行分发
	 * 
	 * @return void
	 */
	public function run()
	{
		list($this->_controller, $this->_action, $this->_params) = array_values($this->_route->parse());
		\MLNPHP\MLNPHP::debug($this->_controller, $this->_action, $this->_params);
	}
}