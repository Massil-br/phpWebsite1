<?php
    require_once '../back/getData.php';
    session_start();
    if(isset($_SESSION['user'])){
        var_dump($_SESSION['user']);
    }
    
    
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>
    <link rel="stylesheet" href="./static/style.css">
</head>
<body>
    <?php include './includes/header.php'; ?>
    <div id="main">
        <div class="left-ad-wrapper">
            <div class="left-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100">
            </div>
        </div>

        <div class="center text-color">
            <div>
                <form id="loginForm" class="login-container d-flex align-items-center justify-content-center flex-column mt-5">
                    <h2>Se connecter</h2>

                    <label for="">Email</label>
                    <input type="email" name="email" required>

                    <label for="">Mot de passe</label>
                    <input type="password" name="password" required>

                    <button id="submit-button"type="submit">Se connecter</button>
                    <div id="registerMsg" class="mt-3 text-center"></div>
                </form>
             </div>

        </div>

        <div class="right-ad-wrapper">
            <div class="right-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100">
            </div>
        </div>
    </div>
    <?php include './includes/footer.php';?>
    <script src="./static/auth.js"></script>
</body>
</html>