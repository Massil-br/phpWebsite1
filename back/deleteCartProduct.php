<?php
require_once './db.php';
global  $db;
header('Content-Type: application/json');


if($_SERVER['REQUEST_METHOD']!=='POST'){
    http_response_code(405);
    echo json_encode([
        'error' => 'Unauthorized: POST method required.'
    ]);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Données JSON invalides']);
    exit;
}

$requiredFields = ['user_id','cart_product_id',];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Le champ '$field' est requis"]);
        exit;
    }
}
$userId= $data['user_id'];
$cartProductId['cart_product_id'];




