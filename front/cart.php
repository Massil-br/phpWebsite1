<?php
require_once   '../back/getData.php';
session_start();
$cartProductsDisplay = [];
$benchmarks = [];
if(!isset($_SESSION['user'])){
    $_SESSION['message']="Vous avez besoin d'être connecté pour accéder au panier";
    header("Location: ./login.php");
    exit;
}
$userId = $_SESSION['user']->GetId();
$response = GetData(['action'=>'getcartproductsbyuserid', 'user_id'=>$userId]);
if(isset($response['error'])){
    var_dump($response['error']);
}else{
    $benchmarks[]=$response['benchmark'];
    $cartProductsDisplay = $response['cartProductsDisplay'];
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="icon" href="./assets/logo.png">
    <link rel="stylesheet" href="./static/style.css">
</head>
<body>
    <?php include './includes/header.php'; ?>
    
   

        
    <div id="main">
        <?php include './includes/leftAdWrapper.php' ?>


        <div class="center">
            <div class="cart d-flex d-flex justify-content-center align-items-center mt-5 flex-column overflow-y-auto mh-80 overflow-x-hidden"  >
                <?php if (!empty($cartProductsDisplay)):
                    foreach($cartProductsDisplay as $cartProductDisplay):
                    ?>
                    <div class="cart-item d-flex justify-content-between mt-3 gap-5 text-color align-items-center flex-wrap bg-reviews w-reviews rounded-2 p-2 ">
                        <a class="nav-link mb-0 " href="./product.php?id=<?=$cartProductDisplay->cartProduct->GetProductId() ?>">
                            <img src="<?= $cartProductDisplay->variantImage->GetRelativeUrl() ?>" alt="Icône" width="48" height="48">
                        </a>
                        <a class="nav-link mx-1 mb-0 " href="./product.php?id=<?=$cartProductDisplay->cartProduct->GetProductId() ?>">
                            <h4 class="cart-p-name"><?= $cartProductDisplay->variant->GetName()?></h4>
                        </a>
                            <?php foreach($cartProductDisplay->cartProduct->variantAttributes as $variantAttribute) :?>
                            <p class="cart-attr mx-1 mb-0"><?= $variantAttribute->GetValue() ?></p>
                            <?php endforeach;?>
                        <div class="quantity-select mx-1 mb-0"><?= $cartProductDisplay->cartProduct->GetQuantity() ?></div>
                        <div>
                            <button onclick="ReduceQuantity(<?= $cartProductDisplay->cartProduct->GetId() ?>)" class="btn btn-light">-</button>
                            <button onclick="AddQuantity(<?= $cartProductDisplay->cartProduct->GetId() ?>)" class="btn btn-light">+</button>
                            
                        </div>
                        <button class="btn btn-danger delete-cart-item ">Supprimer</button>
                    </div> 
                <?php endforeach;endif; ?>
           </div>
           <div class="cart-confirm d-flex justify-content-center align-items-center mt-5">
               <a class="nav-link" href="./checkout.php">
                <button class="btn btn-primary">Procéder au payement</button>
            </a>
           </div>
        

        </div>

        
        <?php include './includes/rightAdWrapper.php' ?>
    


    </div>
    <?php include './includes/footer.php';
        include './includes/benchmark.php';
    ?>

    <script>
        function AddQuantity(cartProductId){
            
        }

        function ReduceQuantity(cartProductId){
            
        }
    </script>


</body>
</html>