<?php
require_once './class/user.php';
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

$requiredFields = ['lastName', 'firstName', 'email', 'emailConfirm', 'phoneNumber', 'password', 'passwordConfirm'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Le champ '$field' est requis"]);
        exit;
    }
}

$firstName = $data['firstName']??null;
$lastName = $data['lastName']??null;
$email = $data['email']?? null;
$confirmEmail = $data['emailConfirm']??null;
$password = $data['password']??null;
$confirmPassword = $data['passwordConfirm']??null;
$phoneNumber = $data['phoneNumber']??null;



if(!$firstName || !$lastName ||!$email || !$confirmEmail || !$password ||!$confirmPassword || !$phoneNumber){
    http_response_code(400);
    echo json_encode(['error' => 'Il manque des éléments sur la requête json']);
    exit;
}

if($email !== $confirmEmail){
    http_response_code(400);
    echo json_encode(['error' => 'email et email confirm  ne sont pas les mêmes']);
    exit;
}

if($password !== $confirmPassword){
    http_response_code(400);
    echo json_encode(['error'=>'mot de passe et confirm mot de passe ne sont pas les mêmes']);
    exit;
}

try{
    if(User::CheckIfEmailExist($db,$email)){
        http_response_code(400);
        echo json_encode(['error'=>'email already exist']);
        exit;
    }

    if (
        strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||        // une majuscule
        !preg_match('/[a-z]/', $password) ||        // une minuscule
        !preg_match('/[0-9]/', $password) ||        // un chiffre
        !preg_match('/[\W]/', $password)            // un caractère spécial
        ) {
        http_response_code(400);
        echo json_encode(['error' => 'Le mot de passe doit contenir au moins 8 caractères, avec majuscule, minuscule, chiffre et symbole']);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    User::CreateUser($db,$firstName,$lastName, $email, $hashedPassword,$phoneNumber);

    if(User::CheckIfEmailExist($db,$email)){
        http_response_code(200);
        echo json_encode(['message'=> 'Vous venez de vous inscrire, Bienvenue']);
        exit;
    }else{
        http_response_code(500);
        echo json_encode(['error'=>"Votre compte n'a pas pu être créé, erreur interne au serveur"]);
    }
    

}catch(ErrorException $e){
    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
    exit;
}



