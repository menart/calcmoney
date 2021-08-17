<?php
include 'index.php';
$data = json_decode(file_get_contents('php://input'));

if (empty($data))
	die(json_encode(['succes' => 0,
		'message' => 'пустой запрос']));
echo json_encode($calc->verifyInsert($data) ?? $calc->insert($data->from_currency, $data->to_currency, $data->amount));