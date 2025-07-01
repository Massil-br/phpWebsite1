<?php
    require_once './includes/header.php';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product detail</title>
    <link rel="icon" href="./assets/logo.png">
    <link rel="stylesheet" href="./static/product.css">
</head>

<body>
    
    <!-- carroussel -->
    <div class="flex-container">

    
        <div id="carrousel">
        <div id="carrousel-container">
            <img src="./assets/carrousel/im1.webp" alt="">
            <img src="./assets/carrousel/im2.webp" alt="">
            <img src="./assets/carrousel/im3.webp" alt="">
            <img src="./assets/carrousel/im4.webp" alt="">
        </div>
        <div class="bouton prev">❮</div>
        <div class="bouton next">❯</div>
        </div>

        <div class="details">
            <h1>Product Name</h1>
            <div class="stars">
                <img src="./assets/starFull.png" alt=""><img src="./assets/starFull.png" alt=""><img src="./assets/starFull.png" alt=""><img src="./assets/starFull.png" alt=""><img src="./assets/starFull.png" alt="">
                <p>1244 reviews</p>
            </div>
            <div class="description">
                <h3>Blue jordan shoes with beautiful color contrast between the top and the botom , materials are all eco-freindly, the leather is from well raised cows</h3>
            </div>
       

            <div class="bot-right-buy">
                <h2 id="price">199$</h2>
                <button id="add-to-cart">Add to cart</button>
            </div>
         </div>

    </div>
    


<?php require_once './includes/footer.php'; ?>
</body>



<script src="./static/product.js" defer></script>
<script src="./static/backGroundAnimation.js"></script>
</html>