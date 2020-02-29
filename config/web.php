<?php

return [
	'basePath' => __DIR__,
	'params' => require 'params.php',
	'databases' => [
		'dev' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'pages'
		],
		'main' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'database2'
		],
	],
	'routes' => function() {
		require_once 'routes.php';
	}
];