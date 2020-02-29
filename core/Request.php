<?php

namespace core;

/**
 * Class Request
 * @property string clientIp
 * @property array post
 */
class Request
{
	public function __get($name)
	{
		if (method_exists($this, $name)) {
			return call_user_func([$this, $name]);
		} else {
			throw new \Exception('Method not found');
		}
	}

	/**
	 * @param null|string $key
	 * @param mixed $default
	 *
	 * @return array|string
	 */
	public function post($key = null, $default = null)
	{
		if (is_null($key)) {
			return $_POST;
		}
		return isset($_POST[$key]) ? $_POST[$key] : $default;
	}

	protected function clientIp()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}