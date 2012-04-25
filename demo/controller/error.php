<?php
namespace APP\Controller;

use \MLNPHP\System\ControllerBase;

class Error extends ControllerBase
{
	protected function initialize()
	{
		$this->_verification();
	}

	protected function destory()
	{
		
	}

	private function _verification() 
	{
		return true;
	}

	public function notfoundAction()
	{
        echo $s;
	}
}