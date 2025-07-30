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

$requiredFields = ['stars','user_id','product_id'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Le champ '$field' est requis"]);
        exit;
    }
}

$hasComment = false;
$stars = $data['stars']??null;
$product_id = $data['product_id']??null;
$userId = $data['user_id']??null;
$comment = $data['comment']??null;

if($stars < 1 || $stars >5){
    http_response_code(400);
    echo json_encode(['error'=>"stars ne peut être inférieur à 1 ou supérieur à 5"]);
    exit;
}
if($comment !== null && $comment !==""){
    $hasComment = true;
}
try{
    $product_review_id = ProductReview::CreateProductReview($db, $product_id,$userId, $stars);

    if($hasComment){
        ProductComment::CreateProductComment($db,$product_id,$userId,$product_review_id,$comment);
    }
}catch(ErrorException $e){
    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
    exit;
}

http_response_code(200);
echo json_encode(['message'=>"Commentaire créé avec succès"]);
exit;



