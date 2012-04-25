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
	protected $request;
    protected $action;

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
        $this->action = $action;
		$this->initialize();
		$this->$action();
		$this->destory();
	}

	/**
	 * 在调用前
	 * 
	 * @return void
	 */
	abstract protected function initialize();

	/**
	 * 在调用后
	 * 
	 * @return void
	 */
	abstract protected function destory();
}