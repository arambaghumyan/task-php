<?php

namespace core;

/**
 * Class Controller
 * @property /PDO $database
 * @property array $params
 */
class Controller
{
	/**
	 * @var Database
	 */
	private $databaseConnection;

	public function __construct()
	{
		if (method_exists($this, 'beforeAction')) {
			$this->beforeAction();
		}
		$this->setDb(App::$data->databases[ENV]);
	}

	public function setDb(array $data)
	{
		$this->databaseConnection = new Database($data);
	}

	public function __get($name)
	{
		if ($name == 'database') {
			return $this->databaseConnection->getInstance();
		}
		return null;
	}

	public function redirect($to)
	{
		return new Redirect($to);
	}
}