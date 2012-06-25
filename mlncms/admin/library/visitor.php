<?php

namespace APP\Library;

use \MLNPHP\Helper\User;
use \APP\Library\MasterPassport;

class Visitor extends User
{
    protected function createPassport()
    {
        return new MasterPassport();
    }    
}