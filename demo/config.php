<?php

use \MLNPHP\System\HttpApplication;

return array(
	'path' => array(
		'controller' => APP_PATH . DS . 'controller',
		'model' => APP_PATH . DS . 'model',
		'template' => APP_PATH . DS . 'view'
	),
	'router' => array(
		'about' => array(
			'controller' => 'article', 
			'action' => HttpApplication::defaultAction, 
			'params' => array(
				'id' => '1'
			)
		),
		'page/{%s}-{%s}-{%d}-{%s}.html' => array(
			'controller' => '$1', 
			'action' => '$2', 
			'params' => array(
				'id' => '$3',
				'type' => '$4'
			)	
		),
		'favicon.ico' => array(
			'controller' => 'ico', 
			'action' => HttpApplication::defaultAction, 
			'params' => array(
				'id' => '1'
			)
		)
	)
);