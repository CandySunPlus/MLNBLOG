<?php
namespace APP\Model;

use \MLNPHP\ORM\Model；

class Category extends Model
{
    public static $dbType = Model::MYSQL;

    public static $relation = array(
        BELONG_TO => array(
            
        ),
        HAS_ONE => array(
            
        ),
        HAS_MANY => array(
            
        )
    );
}