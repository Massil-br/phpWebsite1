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
    $products = [];
    $benchmarks = [];
    $response = GetData(['action'=>'GetAllProducts']);
    if(isset($response['error'])){
        var_dump($response['error']);
    }else{
        $products = $response['products'];
        $benchmarks[]= $response['benchmark'];
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Categories</title>
    <link rel="stylesheet" href="./static/style.css">
</head>
<body>
    <?php include './includes/header.php' ?>*
    <div id="main">
        <div></div>
        <div class="center text-color">
            <div class="d-flex justify-content-center r flex-wrap">
                <h1>CRUD Produits</h1>
            </div>
            <div class="d-flex justify-content-center flex-wrap">
                <button onclick="ShowAddCategory()" class="btn btn-success ">Ajouter un Produit</button>
            </div>
            
            <div class="scroll-container mt-5 ">
                <?php if(!empty($products)):
                foreach($products as $product): ?> 
                        <div class="  d-flex justify-content-between  m-1  text-color align-items-center flex-wrap bg-reviews w-100 gap-2 rounded-2 p-2 w-reviews">
                            <p class="mb-0">ID: <?= $product->GetId() ?></p>
                            <h4 class="mb-0"><?= $product->GetName() ?></h4>
                            <div class="d-flex overflow-auto align-items-center" style="width: 25%; height: 8rem;">
                                <p class="mb-0"><?= $product->GetDescription() ?></p>
                            </div>
                            <div>
                                <a href="./crudVariants.php?id=<?= $product->GetId() ?>"><button class="btn btn-success ">Variants</button></a>
                                <button onclick="EditCategory(<?= $product->GetId() ?>)" class="btn btn-warning ">Modifier</button>
                                <button onclick="DelCategory(<?= $product->GetId() ?>)" class="btn btn-danger ">Supprimer</button>
                            </div>
                        </div>
                <?php endforeach;endif; ?>
             </div>
             


            

            

        </div>
        <div></div>
    </div>


    <?php include './includes/footer.php';
    include './includes/benchmark.php'; ?>
    
</body>
</html>