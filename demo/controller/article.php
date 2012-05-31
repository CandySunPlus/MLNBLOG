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
        // $articleModel = model('Article');
        // $articleEntity = $articleModel::create();
        // $articleEntity->title = 'hello';
        // $articleEntity->content = 'this is a new art';
        // $articleEntity->categoryId = 1;
        // $articleEntity->save();
        // $articleEntity->categoryId = 2;
        // $articleEntity->save();
        // debug($articleEntity->id);
        // $articleEntity->title = 'world';
        // $articleEntity->save();
        // $mysql->getLastQuery();
        // debug($mysql->getTables());
        // $this->output($this->request->get('id'));
        // $categoryModel = model('Category');
        // $categoryEntity = $categoryModel::get(2);
        // $this->output($categoryEntity->name);
        // $categoryEntity->name = '分类二';
        // $categoryEntity->save();
        $articleModel = model('Article');
        $articleEntity = $articleModel::get(1);
        $this->output($articleEntity->category->name);
        $this->output($articleEntity->title);
        $categoryEntity = $articleEntity->category;
        
        foreach ($categoryEntity->articles as $article) {
            $this->output($article->id);
        }

    }
}