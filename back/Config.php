<?php

class Config
{

	private static Config $thisConfig;
	private array $config;

	private function __construct($path)
	{
		$this->config = parse_ini_file($path, true, INI_SCANNER_TYPED);
	}

	public static function getConfig($path): Config
	{
		if(!isset(self::$thisConfig))
			self::$thisConfig = new self($path);
		return self::$thisConfig;
	}

	public function getParam($param)
	{
		return $this->config[$param];
	}

}