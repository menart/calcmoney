<?php
include 'index.php';


$result['header'] = ['id' => 0, 'name' => 1];
/**
 * @var Calc
 */
$listCurrency = $calc->getListCurrency();

foreach ($listCurrency as $currency)
	$result['data'][] = [
		$currency[0],
		$currency[1]
	];
echo json_encode($result);