<?php

return array(
	
	'fetch' => PDO::FETCH_CLASS,
	
	'default' => 'mysql',
	
	'connections' => array(
		
		'mysql' => array(
			
			'driver'    => 'mysql',
			'host'      => '192.168.1.251',
			'database'  => 'test_erp',
			'username'  => 'dev',
			'password'  => 'dev123456',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => 'lv4_',
		),

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => __DIR__.'/../database/production.sqlite',
			'prefix'   => '',
		),
		
	),
	
	'migrations' => 'migrations',
);