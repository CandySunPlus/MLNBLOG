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
		'page/art-show-{%d}-{%s}.html' => array(
			'controller' => 'art', 
			'action' => 'show', 
			'params' => array(
				'id' => '$1',
				'type' => '$2'
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
