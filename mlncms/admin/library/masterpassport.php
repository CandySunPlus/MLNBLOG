<?php
namespace APP\Library;

use \MLNPHP\Helper\Passport;

class MasterPassport extends Passport
{
    protected function getUserModel()
    {
        return model('Masters');
    } 
}