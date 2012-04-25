<?php
namespace APP\Controller;

use \MLNPHP\System\ControllerBase;

class Article extends ControllerBase
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

	public function showAction()
	{
		$this->output($this->request->get('id'));
	}
}