<?php
namespace APP\Model;

use \MLNPHP\ORM\Model;

class Article extends Model
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
    public function test()
    {
        debug(self::$primaryKey);
    }
}