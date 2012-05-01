<?php
namespace APP\Model;

use \MLNPHP\ORM\Model;

class Article extends Model
{
    public static $dbType = Model::MYSQL;

    public function test()
    {
        debug(self::$primaryKey);
    }
}