<?php
include 'index.php';


$result['header'] = ['id' => 0, 'name' => 1];
/**
 * @var Calc
 */
$result['data'] = $calc->getListCurrency();
echo json_encode($result);