<?php
include 'Calc.php';
include 'DB.php';

try {
	$db = new DB();
	$calc = new Calc($db);
} catch (Exception $e) {
	echo $e->getMessage(), "\n";
}