<?php
include 'index.php';
$data = json_decode(file_get_contents('php://input'));

if (empty($data))
	die(json_encode(['succes' => 0,
		'message' => 'пустой запрос']));


$result['success'] = 1;
$result['updated'] = [];
foreach ($data->updated as $updated)
	$result['updated'][] = $calc->update($updated->id, $updated->from_currency, $updated->to_currency, $updated->amount);

foreach ($data->deleted as $deleted)
	if ($calc->delete($deleted->id) == false)
		die(json_encode(['success' => 0,
			'message' => 'повторное удаление']));

echo json_encode($result);
