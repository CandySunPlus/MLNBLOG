<?php
namespace MLNPHP\System;

use \MLNPHP\Helper\Request;
use \MLNPHP\Helper\Response;
use \MLNPHP\System\View;

/**
 * 控制器基类
 * 
 * @package MLNPHP
 */
abstract class ControllerBase
{
	protected $request;
    protected $action;
    protected $controller;
    protected $view;

	public function __construct($params)
	{
		$this->request = Request::getInstance();
		$this->request->set($params, Request::GET);	
		$this->controller = get_called_class();
		$this->view = new View();
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
	 * 输出页面
	 * 
	 * @param string $content 页面内容
	 * 
	 * @return void
	 */
	public function output($content)
	{
		Response::output($content);
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