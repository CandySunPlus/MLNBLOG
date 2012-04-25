<?php

use \MLNPHP\System\HttpApplication;

return array(
	'debug' => true,
	'path' => array(
		'controller' => 'APP\\Controller',
		'model' => 'APP\\Model',
		'template' => 'APP\\View'
	),
	'page' => array(
		'404' => array(
			'controller' => 'error', 
			'action' => 'notfound', 
			'params' => array()
		)
	),
	'router' => array(
		'about' => array(
			'controller' => 'article', 
			'action' => HttpApplication::defaultAction, 
			'params' => array(
				'id' => '1'
			)
		),
		'page/art-show-{%d}.html' => array(
			'controller' => 'article', 
			'action' => HttpApplication::defaultAction, 
			'params' => array(
				'id' => '$1'
			)	
		),
		'favicon.ico' => array(
			'controller' => 'ico', 
			'action' => HttpApplication::defaultAction, 
			'params' => array(
				'id' => '1'
			)
		)
	),
    'timezone' => 'Asia/Shanghai'
);
