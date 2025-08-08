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
    $productId = null;
    $productDetail = null;
    $benchmarks = [];
    if(isset($_GET['id'])){
        $productId = (int)$_GET['id'];
    }
    $response = GetData(['action'=>'GetProductDetail', 'id'=>$productId]);
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
    <title>Crud Variants</title>
    <link rel="stylesheet" href="./static/style.css">
</head>
<body>
    <?php include './includes/header.php' ?>*
    <div id="main">
        <div></div>
        <div class="center text-color">
            <div class="d-flex justify-content-center r flex-wrap">
                <h1>CRUD Variants of <?= $productDetail->product->GetName()?> </h1>
            </div>
            <div class="d-flex justify-content-center flex-wrap">
                <button onclick="ShowAddCategory()" class="btn btn-success ">Ajouter un Produit</button>
            </div>
            
            <div class="scroll-container mt-5 ">
                <?php if(!empty($productDetail)):
                foreach($productDetail->variants as $variant): ?> 
                        <div class="  d-flex justify-content-between  m-1  text-color align-items-center flex-wrap bg-reviews w-100 gap-2 rounded-2 p-2 w-reviews">
                            <p class="mb-0">ID: <?= $variant->GetId() ?></p>
                            <h4 class="mb-0"><?= $variant->GetSku() ?></h4>
                            <h4 class="mb-0"><?= $variant->GetPrice() ?>€</h4>
                            <h4 class="mb-0"><?= $variant->GetStock() ?></h4>
                            <div>
                                <a href="crudVariantImages.php?id=<?= $variant->GetId() ?>"><button  class="btn btn-success ">Images</button></a>
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