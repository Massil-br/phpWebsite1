<?php
    require_once '../back/getData.php';
    session_start();
    include './includes/sessionMessage.php';
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
        <?php include './includes/leftAdWrapper.php' ?>

        <div class="center text-color">
            <div>
                <form id="loginForm" class="login-container d-flex align-items-center justify-content-center flex-column mt-5">
                    <h2>Se connecter</h2>

                    <label for="email">Email</label>
                    <input id="email"type="email" name="email" required autocomplete="email">

                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">

                    <button id="submit-button"type="submit">Se connecter</button>
                    <div id="registerMsg" class="mt-3 text-center"></div>
                </form>
             </div>

        </div>

        <?php include './includes/rightAdWrapper.php' ?>
    </div>
    <?php include './includes/footer.php';?>
    <script src="./static/auth.js"></script>
</body>
</html>