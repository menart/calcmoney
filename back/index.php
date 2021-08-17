<?php
include 'Config.php';
include 'Calc.php';
include 'DB.php';

const PATH_INI = '/usr/local/etc/php/conf.d/dsn.ini';
const DSN_PARAM = 'pdo.dsn.testdb';

try {
	$config = Config::getConfig(PATH_INI);
	$db = new DB($config->getParam(DSN_PARAM));
	$calc = new Calc($db);
} catch (Exception $e) {
	echo $e->getMessage(), "\n";
}