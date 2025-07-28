<?php
require_once './class/user.php';
require_once './db.php';
global  $db;
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD']!=='POST'){
    http_response_code(401);
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

$requiredFields = ['email', 'password'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Le champ '$field' est requis"]);
        exit;
    }
}

$email = $data['email']?? null;
$password = $data['password']??null;

if (!$email || !$password) {
    http_response_code(400); 
    echo json_encode(['error' => 'il manque des éléments sur la requete json']);
    exit;
}


if(!User::CheckIfEmailExist($db,$email)){
    http_response_code(400);
    echo json_encode(['error'=>'email ou mot de passe incorrect']);
    exit;

}

if(!password_verify($password,User::GetPasswordHashByEmail($db,$email))){
    http_response_code(401);
    echo json_encode(['error'=>'email ou mot de passe incorrect']);
    exit;
}
try{
    $user = User::GetUserByEmail($db,$email);
    $firstName = $user->getFirstName();
   // Démarrer la session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Stocker les informations utilisateur
    $_SESSION['user'] = $user;
   
    
    http_response_code(200);
    echo json_encode([
        'message' => "Bienvenue $firstName", 
        'userId' => $user->getId(),
        'success' => true
    ]);
}catch(Exception $e){
    http_response_code(400);
    echo json_encode(['error'=>$e->getMessage()]);
    exit;
}


