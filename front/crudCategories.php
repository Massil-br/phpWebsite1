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
    $benchmarks = [];
    $categories=[];
    
    $categories = [];
    $response = GetData(['action'=>'GetCategories']);
    if(isset($response['error'])){
        var_dump($response['error']);
    }else{
        $categories = $response['categories'];
        $benchmarks[]=$response['benchmark'];
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
                <h1>CRUD Catégories</h1>
            </div>
            <div class="d-flex justify-content-center flex-wrap">
                <button onclick="ShowAddCategory()" class="btn btn-success ">Ajouter une catégorie</button>
            </div>
            
            <div class="scroll-container mt-5 ">
                <?php if(!empty($categories)):
                foreach($categories as $category): ?> 
                        <div class="  d-flex justify-content-between  m-1  text-color align-items-center flex-wrap bg-reviews w-100 gap-2 rounded-2 p-2 w-reviews">
                            <p class="mb-0">ID: <?= $category->GetId() ?></p>
                            <h4 class="mb-0"><?= $category->GetName() ?></h4>
                            <div class="d-flex overflow-auto align-items-center" style="width: 25%; height: 8rem;">
                                <p class="mb-0"><?= $category->GetDescription() ?></p>
                            </div>
                            <div>
                                <button onclick="EditCategory(<?= $category->GetId() ?>)" class="btn btn-warning ">Modifier</button>
                                <button onclick="DelCategory(<?= $category->GetId() ?>)" class="btn btn-danger ">Supprimer</button>
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