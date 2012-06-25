<?php

use \MLNPHP\System\HttpApplication;
use \MLNPHP\ORM\Adapter\Abstraction\AdapterBase;

return array(
	'debug' => true,
	'path' => array(
		'controller' => 'APP\\Controller',
		'model' => 'APP\\Model',
		'template' => 'APP\\View'
	),
    'timezone' => 'Asia/Shanghai',
    'db' => array(
        'use' => 'devel',
    	'devel' => array(
    		'type' => AdapterBase::MYSQL,
    		'host' => '127.0.0.1:3306',
    		'username' => 'root',
    		'password' => 'root',
    		'dbname' => 'mlncms',
            'charset' => 'utf8',
            'prefix' => 'pre_'
    	)
    )
);
