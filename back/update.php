<?php
include 'index.php';
$data = json_decode(file_get_contents('php://input'));

$result['success'] = 1;
foreach($data->updated as $updated)
	$result['updated'][] = $calc->update($updated->id, $updated->from_currency,$updated->to_currency, $updated->amount);
echo json_encode($result);