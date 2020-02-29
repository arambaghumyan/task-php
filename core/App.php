<?php

namespace core;

use AppData;
use core\router\Router;

class App
{
	/**
	 * @var AppData
	 */
	public static $data;

	private $router;
	private $database;

	public function __construct(array $config)
	{
		$basePath = realpath($config['basePath'].'/../');
		spl_autoload_register(function($class) use ($basePath) {
			autoload::load($class, $basePath);
		});
		define('ENV_DEV', defined('ENV') && ENV == 'dev');

		$config['routes']();

		$this->router = new BasicRouter([]);
		$this->routing = new Router($this->router->getCurrentUrl());
		static::$data = new AppData();
		static::$data->params = $config['params'];
		static::$data->request = new Request();
		static::$data->basePath = $basePath;
		static::$data->databases = $config['databases'];
		$this->setAppData();
	}

	public function setAppData()
	{
		static::$data->baseUrl = $this->router->getBaseUrl();
		static::$data->routes = $this->router->getUrlRoutes();
		static::$data->webDir = getcwd();
		static::$data->appDir = realpath(__DIR__.'/../');
	}

	public function start()
	{
		if ($this->routing->isRouteFound()) {
			$controller = '\\controllers\\' . sprintf('%sController', ucfirst(strtolower($this->routing->getController())));
			$action = sprintf('%sAction', strtolower($this->routing->getAction()));
			$result = call_user_func_array([new $controller(), $action], $this->routing->getParams());
		} else {
			header("HTTP/1.0 404 Not Found");
			die;
		}

		if ($result instanceof Processor) {
			$result->process();
		} elseif (is_array($result)) {
			header('Content-Type: application/json');
			echo json_encode($result);
		} else {
			echo $result;
		}
	}

}