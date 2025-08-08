<?php
    require_once   '../back/getData.php';
    session_start();
    if(!isset($_SESSION['user'])){
        $_SESSION['message']="Vous devez être connecté avec un compte administrateur pour accéder à cette page";
        header("Location: ./login.php");
        exit;
    }

    if($_SESSION['user']->GetRole() !== 'admin'){
        if($_SESSION['user']->GetRole()!=='dev'){
            $_SESSION['message']="Vous devez être connecté avec un compte administrateur pour accéder à cette page";
            header("Location: ./login.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminDashboardHome</title>
     <link rel="icon" href="./assets/logo.png">
    <link rel="stylesheet" href="./static/style.css">
</head>
<body>
    <?php include './includes/header.php'; ?>
    <div id="main">
        <div></div>
             <div class="center">
        <div class="d-flex  flex-wrap p-4 gap-3 align-items-center justify-content-evenly ">
            <div class="card d-flex flex-wrap text-center" style="width: 18rem;">
                <a class="text-decoration-none" href="crudCategories.php">
                <div class="card-body bg-reviews text-color">
                    <h5 class="card-title">CRUD Catégories</h5>
                    <p class="card-text">Pour modifier ajouter ou supprimer des catégories</p>
                    <p class="btn btn-primary">aller au crud catégories</p>
                </div>
                </a>
            </div>
            <div class="card d-flex flex-wrap text-center" style="width: 18rem;">
                <a class="text-decoration-none" href="crudSubcategories.php">
                <div class="card-body bg-reviews text-color">
                    <h5 class="card-title">CRUD Sous -catégories</h5>
                    <p class="card-text">Pour modifier ajouter ou supprimer des Sous-catégories</p>
                    <p class="btn btn-primary">aller au crud Sous-catégories</p>
                </div>
                </a>
            </div>
             <div class="card d-flex flex-wrap text-center" style="width: 18rem;">
                <a class="text-decoration-none" href="crudProducts.php">
                <div class="card-body bg-reviews text-color">
                    <h5 class="card-title">CRUD Produits</h5>
                    <p class="card-text">Pour modifier ajouter ou supprimer des Produits</p>
                    <p class="btn btn-primary">aller au crud Produits</p>
                </div>
                </a>
            </div>
        </div>
    </div>  
        <div></div>
    </div>
   

    <?php include './includes/footer.php';?>
</body>
</html>