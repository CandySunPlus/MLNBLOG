<?php
namespace APP\Model;

use \MLNPHP\ORM\Model;

class Article extends Model
{
    protected static $dbType = Model::MYSQL;
    protected static $foreignKey = 'articleId';
    
    protected static $relation = array(
        Model::BELONGS_TO => array(
            'category' => "APP\\Model\\Category"
        ),
        Model::HAS => array(
            
        )
    );
    public function test()
    {
        debug(self::$primaryKey);
    }
}