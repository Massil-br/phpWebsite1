<?php
    require_once '../back/getData.php';

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
            <div >
                <form id="registerForm" class="register-container d-flex align-items-center justify-content-center flex-column mt-5" >
                    <h2>S'inscrire</h2>

                    <label for="">Nom</label>
                    <input type="text" name="lastName" required>

                    <label for="">Prénom</label>
                    <input type="text" name="firstName" required>

                    <label for="">Email</label>
                    <input type="email" name="email" required>

                    <label for="">Confirmer l'email</label>
                    <input type="email" name="emailConfirm" required>

                    <label for="">Numéro de téléphone</label>
                    <input type="text" name="phoneNumber" required>

                    <label for="">Mot de passe</label>
                    <input type="password" name="password" required>

                    <label for="">Confirmer le mot de passe</label>
                    <input type="password" name="passwordConfirm" required>

                    <button type="submit" id="submit-button">S'inscrire</button>
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