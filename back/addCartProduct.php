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

$requiredFields = ['user_id','variant_id','quantity', 'variant_attribute_ids'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Le champ '$field' est requis"]);
        exit;
    }
}

$userId = $data['user_id'];;
$variant_id = $data['variant_id'];;
$quantity = $data['quantity'];
$variantAttributeIds = $data['variant_attribute_ids'];

$cartId = Cart::GetCartIdByUserId($db,$userId);
if($cartId === -1){
    Cart::CreateCartIfNotExists($db,$userId);
    $cartId = Cart::GetCartIdByUserId($db, $userId);
    if($cartId === -1){
        http_response_code(500);
        echo json_encode(['error'=>" impossible de créer un panier pour l'utilisateur id: $userId"]);
        exit;
    }
}

try{
    CartProduct::AddProductToCart($db,$cartId,$variant_id,$quantity, $variantAttributes);
}catch(ErrorException $e){
    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
    exit;
}

http_response_code(201);
echo json_encode(['message'=>'Produit ajouté au panier avec succès']);
exit;