<?php

namespace core;

class Database
{
	/**
	 * @var \PDO
	 */
	private static $instance;

	private $host;
	private $database;
	private $username;
	private $password;

	public function __construct( $config )
	{
		$this->host = $config['host'];
		$this->database = $config['database'];
		$this->username = $config['username'];
		$this->password = $config['password'];
	}

	private function openConnection()
	{
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;

		$options = array(
			\PDO::ATTR_PERSISTENT => true,
			\PDO::ATTR_ERRMODE    => \PDO::ERRMODE_EXCEPTION
		);

		static::$instance = new \PDO( $dsn, $this->username, $this->password, $options );
	}

	/**
	 * @return \PDO
	 */
	public function getInstance()
	{
		if (!static::$instance) {
			$this->openConnection();
		}
		return static::$instance;
	}
}

