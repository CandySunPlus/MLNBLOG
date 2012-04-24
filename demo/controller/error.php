<?php
namespace APP\Controller;

use \MLNPHP\System\ControllerBase;

class Error extends ControllerBase
{
	protected function initialize($controllerCls, $action)
	{
		$this->_verification($controllerCls, $action);
	}

	protected function destory($controllerCls, $action)
	{
		
	}

	private function _verification($controllerCls, $action) 
	{
		return true;
	}

	public function notfoundAction()
	{

	}
}