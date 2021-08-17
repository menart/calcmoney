<?php
include 'index.php';
$data = json_decode(file_get_contents('php://input'));

echo json_encode($calc->insert($data->from_currency, $data->to_currency,$data->amount));