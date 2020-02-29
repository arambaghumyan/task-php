<?php

namespace core;

class autoload
{
	public static $folderMap = [];

	public static function load($class_name, $basePath)
	{
		if (empty(self::$folderMap)) {
			self::$folderMap = self::dirToArray($basePath);
		}
		foreach(self::$folderMap as $path)
		{
			$file = $path.DIRECTORY_SEPARATOR.$class_name.'.php';
			if(file_exists($file))
				require_once $file;
		}
	}

	public static function dirToArray($directory, array $only=array())
	{
		if(empty($directory))
			return array();
		$result = [$directory];
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		foreach ($scanned_directory as $value)
		{
			if($only && !in_array($value, $only)) {
				continue;
			}
			if(is_dir($directory.DIRECTORY_SEPARATOR.$value))
			{
				$list = self::dirToArray($directory.DIRECTORY_SEPARATOR.$value);
				if(!empty($list))
					$result = array_merge($result, $list);
			}
		}
		return $result;
	}
}