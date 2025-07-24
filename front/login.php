<?php
    require_once '../back/getData.php';
    session_start();
    $_SESSION['user']= new User(1,new DateTime(),"massil","braik","massilbraik0@gmail.com", "012012102", role::User );
    header('Location: index.php');
?>