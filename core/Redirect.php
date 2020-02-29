<?php

namespace core;

class Redirect implements Processor
{
	private $url;

	public function __construct($url)
	{
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			$this->url = $url;
		}
	}

	public function process()
	{
		header(sprintf('location: %s', $this->url));die;
	}
}