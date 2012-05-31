<?php
namespace APP\Model;

use \MLNPHP\ORM\Model;

class Category extends Model
{
    protected static $dbType = Model::MYSQL;
    protected static $foreignKey = 'categoryId';

    public static $relation = array(
        Model::BELONGS_TO => array(
            
        ),
        Model::HAS => array(
            'articles' => "APP\\Model\\Article"
        )
    );
}