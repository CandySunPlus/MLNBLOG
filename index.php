<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', realpath(__DIR__));
define('F_PATH', ROOT_PATH . DS . 'mlnphp');
define('APP_PATH', ROOT_PATH . DS . 'demo');

require F_PATH . DS . 'bootstrap.php';

$config = \MLNPHP\Helper\ConfigReader::get();

$demoApp = \MLNPHP\MLNPHP::getApplication($config);
$demoApp->run();