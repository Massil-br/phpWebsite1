<?php

$host = 'localhost';
$port='3307';
$db = 'ecommerce_template_1';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "myqsl:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try{
    $pdo = new PDO($dsn,$user,$pass, $options);
    echo "✅ Connexion réussie !";
}catch(\PDOException $e){
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
    

