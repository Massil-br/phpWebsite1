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
    $variantId = null;
    $productDetail = null;
    $benchmarks = [];
    if(isset($_GET['id'])){
        $variantId = (int)$_GET['id'];
    }
    $response = GetData(['action'=>'GetProductDetail', 'id'=>$variantId]);
    if(isset($response['error'])){
        var_dump($response['error']);
    }else{
        /**
         * @var ProductDetail
         */
        $productDetail = $response['productDetail'];
        $benchmarks[]= $response['benchmark'];
        
       
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Variant Images</title>
    <link rel="stylesheet" href="./static/style.css">
</head>
<body>
    <?php include './includes/header.php' ?>*
    <div id="main">
        <div></div>
        <div class="center text-color">
            <div class="d-flex justify-content-center r flex-wrap text-break">
                <h1>CRUD Variant Images of <?= $actualVariant?></h1>
            </div>
            <div class="d-flex justify-content-center flex-wrap">
                <button onclick="ShowAddCategory()" class="btn btn-success ">Ajouter un Produit</button>
            </div>
            
            <div class="scroll-container mt-5 ">
                <?php if(!empty($images)):
                foreach($images as $img): ?> 
                        <div class="  d-flex justify-content-between  m-1  text-color align-items-center flex-wrap bg-reviews w-100 gap-2 rounded-2 p-2 w-reviews text-break">
                            <p class="mb-0">ID: <?= $img->GetId() ?></p>
                            <h4 class="mb-0"><?= $img->GetAlt() ?></h4>
                            <h4 class="mb-0"><?= $img->GetimageName() ?></h4>
                            <h4 class="mb-0"><?= $img->GetPosition() ?></h4>
                            
                            <div>
                                
                                <button onclick="EditCategory(<?= $variant->GetId() ?>)" class="btn btn-warning ">Modifier</button>
                                <button onclick="DelCategory(<?= $variant->GetId() ?>)" class="btn btn-danger ">Supprimer</button>
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