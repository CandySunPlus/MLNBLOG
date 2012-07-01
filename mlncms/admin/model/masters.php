<?php
namespace APP\Model;

use \MLNPHP\ORM\Model;

class Masters extends Model
{
    protected static $relation = array(
        Model::HAS => array(),
        Model::BELONGS_TO => array(
            'mastergroups' => "\\APP\\Model\\MasterGroups"
        )
    );
    
    public static function getUserByName($name)
    {
        return self::query()->select()->where('username', '=', $name)->fetch();
    }
}