<?php
namespace APP\Model;

use \MLNPHP\ORM\Model;

class MasterGroups extends Model
{
    protected static relation = array(
        Model::HAS => array(
            'masters' => "\\APP\\Model\\Masters"
        ),
        Model::BELONGS_TO => array()
    );
}