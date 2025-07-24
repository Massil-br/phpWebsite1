<?php
require_once   '../back/getData.php';
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
        <div class="left-ad-wrapper">
            <div class="left-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100">
            </div>
        </div>


        <div class="center">
            <div class="cart d-flex d-flex justify-content-center align-items-center mt-5 flex-column overflow-y-auto mh-80">
                <div class="cart-item d-flex justify-content-center mt-5 gap-5 text-color align-items-center">
                    <a class="nav-link " href="./product.php?productid=this->productid">
                        <img src="product-img" alt="product">
                    </a>
                    <a class="nav-link " href="./product.php?productid=this->productid">
                        <h4 class="cart-p-name">product name</h4>
                    </a>
                    <h5 class="cart-p-description">product description</h5>
                        <p class="cart-attr m-0">attribute1 value</p>
                        <p class="cart-attr m-0">attribute2 value</p>
                    <div class="quantity-select">- 5 +</div>
                    <button class="delete-cart-item ">Supprimer</button>
                </div> 
           </div>
           <div class="cart-confirm d-flex justify-content-center align-items-center mt-5">
               <a class="nav-link" href="./checkout.php">
                <button>Procéder au payement</button>
            </a>
           </div>
        

        </div>

        
        <div class="right-ad-wrapper">
            <div class="right-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100">
            </div>
        </div>
    


    </div>
    <?php include './includes/footer.php'; ?>
</body>
</html>