<?php
include 'Calc.php';

try {
	$calc = new Calc();
} catch (Exception $e) {
	echo $e->getMessage(), "\n";
}