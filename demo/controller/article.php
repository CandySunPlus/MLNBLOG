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
		$articleModel = model('Article');
		$articleEntity = $articleModel::create();
		$articleEntity->title = 'hello';
        $articleEntity->content = 'this is a new art';
        $articleEntity->categoryId = 1;
		$articleEntity->save();
        debug($articleEntity->id);
        $articleEntity->title = 'world';
        $articleEntity->save();
		//$mysql->getLastQuery();
		//debug($mysql->getTables());
		//$this->output($this->request->get('id'));
	}
}