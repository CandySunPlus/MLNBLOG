<?php
namespace APP\Library;

use \MLNPHP\Helper\Passport;

class ManagerPassport extends Passport
{
    protected function getUserModel()
    {
        return model('Manager');
    } 
}