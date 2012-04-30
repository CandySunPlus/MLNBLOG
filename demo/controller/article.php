<?php
namespace APP\Controller;

use \MLNPHP\System\ControllerBase;
use \MLNPHP\ORM\Adapter\Mysql\Mysql;

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
		$mysql = Mysql::getInstance('devel');
		$this->output($this->request->get('id'));
	}
}