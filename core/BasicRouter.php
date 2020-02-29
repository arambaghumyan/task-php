<?php

namespace core;

class BasicRouter
{
	private $routes;
	private $baseUrl;
	private $currentUrl;
	private $currentRoute;

	public function __construct($routes)
	{
		foreach ($routes as $route => $destination) {
			$this->routes[trim($route, '/')] = $destination;
		}
		$this->setBaseUrl();
		$this->setCurrentUrl();
		$this->setCurrentRoute();
	}

	private function setBaseUrl()
	{
		$this->baseUrl = rtrim(str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), '/');
	}

	private function setCurrentUrl()
	{
		$this->currentUrl = str_replace($this->baseUrl, '', $_SERVER['REQUEST_URI']);
	}

	private function setCurrentRoute()
	{
		$route = trim($this->currentUrl, '/');
		$this->currentRoute = isset($this->routes[$route]) ? $this->routes[$route] : null;
	}

	public function getCurrentUrl()
	{
		return $this->currentUrl;
	}

	public function getBaseUrl()
	{
		return sprintf('%s://%s%s', $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST'], $this->baseUrl);
	}

	public function getUrlRoutes()
	{
		return explode('/', trim($this->currentUrl, '/'));
	}

	public function getAction()
	{
		if ($this->currentRoute) {
			return sprintf('action%s', ucfirst($this->currentRoute));
		}
		return null;
	}
}