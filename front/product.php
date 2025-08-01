
<?php
require_once   '../back/getData.php';

if(isset($_GET['id'])){
    $product_id = (int)$_GET['id'];
    $response = GetData(['action'=>'getProductDetail', 'id' => $product_id]);
    $benchmarks =[];
    $commentReviews = [];

    if(isset($response['error'])){
        var_dump($response['error']);
    }else{
        /**
         * @var ProductDetail
         */
        $productDetail = $response['productDetail'];
        $benchmarks[]= $response['benchmark'];

        usort($productDetail->variantImages, function($a, $b) {
        return $a->GetPosition() <=> $b->GetPosition();
        });

        $firstImage = $productDetail->variantImages[0];
    }

    $response = GetData(['action'=>'getCommentReviewsById', 'id'=>$product_id]);
    if(isset($response['error'])){
        var_dump($response['error']);
    }else{
        $commentReviews = $response['commentReviews'];    
        $benchmarks[]= $response['benchmark']; 
    }

    

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product detail</title>
    <link rel="icon" href="./assets/logo.png">
    <link rel="stylesheet" href="./static/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
<?php include './includes/header.php';
    if(isset($productDetail)):
?>
<div id="main">
    <?php include './includes/leftAdWrapper.php' ?>

    <div class="center">
       <div class="container-fluid">
            <div class="product-container">
                <div class="row">
                    <!-- Carousel d'images -->
                    <div class="col-lg-6 col-md-12">
                        <div class="carousel-container">
                            <div class="image-counter">
                                <span id="current-image">1</span> / <span id="total-images">5</span>
                            </div>
                            <img id="main-image" src="<?= htmlspecialchars($firstImage->GetRelativeUrl()) ?>" alt="<?= htmlspecialchars($firstImage->GetAlt())?>" class="main-image">
                            
                            <div class="thumbnail-container">
                                <?php 
                                $count =  count($productDetail->variantImages);
                                if($count > 1):
                                    for($i = 1; $i < $count ; $i++): ?>
                                        <img src="<?= htmlspecialchars($productDetail->variantImages[0]->GetRelativeUrl()) ?>" alt="<?= htmlspecialchars($productDetail->variantImages[0]->GetAlt()) ?>" class="thumbnail active" data-index="0">
                                <?php endfor; endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Informations produit -->
                    <div class="col-lg-6 col-md-12">
                        <div class="product-info">
                            <h1 class="product-title"><?= htmlspecialchars($productDetail->product->GetName())?></h1>
                            <div class="product-price"><?= htmlspecialchars($productDetail->variants[0]->GetPrice())?> €</div>
                            
                            <div class="product-rating">
                                <span class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </span>
                                <span class="text-color">(4.5/5 - 127 avis)</span>
                            </div>

                            <p class="product-description text-color">
                                <?= htmlspecialchars($productDetail->product->GetDescription())?>
                            </p>
                            <?php foreach($productDetail->attributes as $attribute): ?>
                            <div class="filter-selector">
                                <label class="form-label fw-bold text-color"><?= htmlspecialchars(strtoupper($attribute->GetName()))?> :</label>
                                <div class="d-flex flex-wrap row-gap-2">
                                    <?php 
                                        $variantAttributes = [];
                                        for($i =0; $i < count($productDetail->variantAttributes); $i++){
                                            if ($productDetail->variantAttributes[$i]->GetAttributeId() == $attribute->GetId()){
                                                $variantAttributes[]=$productDetail->variantAttributes[$i];
                                            }
                                        }
                                    
                                    foreach($variantAttributes as $variantAttribute):?>
                                    <button class="size-btn" data-attribute="<?= htmlspecialchars($attribute->GetName()) ?>" data-value="<?= htmlspecialchars($variantAttribute->GetValue())?>"><?= htmlspecialchars($variantAttribute->GetValue())?></button>
                                    
                                    <?php endforeach;?>
                                </div>
                            </div>
                            <?php endforeach;?>

                            <div class="quantity-selector">
                                <label class="form-label fw-bold me-3 text-color">Quantité:</label>
                                <button class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                                <input type="number" class="quantity-input" value="1" min="1" max="10" id="quantity">
                                <button class="quantity-btn" onclick="changeQuantity(1)">+</button>
                            </div>

                            <button class="btn btn-primary add-to-cart-btn" onclick="addToCart()">
                                <i class="fas fa-shopping-cart me-2"></i>Ajouter au panier
                            </button>

                            <button class="btn btn-outline-secondary w-100" onclick="addToWishlist()">
                                <i class="fas fa-heart me-2"></i>Ajouter à la liste de souhaits
                            </button>

                            <ul class="product-features">
                                <li class=" text-color"><i class="fas fa-truck feature-icon"></i>Livraison gratuite dès 50€</li>
                                <li class=" text-color"><i class="fas fa-undo feature-icon"></i>Retour gratuit sous 30 jours</li>
                                <li class=" text-color"><i class="fas fa-shield-alt feature-icon"></i>Garantie 2 ans</li>
                                <li class=" text-color"><i class="fas fa-medal feature-icon"></i>Produit authentique Nike</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour l'agrandissement des images -->
        <div class="image-modal" id="imageModal">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <button class="modal-nav modal-prev" onclick="changeModalImage(-1)">❮</button>
            <button class="modal-nav modal-next" onclick="changeModalImage(1)">❯</button>
            <img class="modal-content" id="modalImage" alt="Image agrandie">
        </div>

        <div class="createReview d-flex flex-wrap justify-content-center align-items-center flex-column text-color">
            <p>N'hésitez pas à donner votre avis sur le produit</p>
            <button class="btn btn-primary" onclick="Review()">Noter ou donner un avis sur le produit</button>
            <form class="d-flex align-items-center justify-content-center flex-wrap flex-column  d-none" id ="reviewForm" action="">
                <label for="stars">Stars</label>
                <input id="stars" name="stars" type="number" min="1" max="5" >
                <label for="comment">Comment (optional)</label>
                <input id="comment" name="comment" type="text">
                <button id="submit-button" type="submit">Enregistrer l'avis</button>
                <div id="msg"></div>
            </form>
        </div>

        <?php if(!empty($commentReviews)): ?>
        <div class="comments-section d-flex justify-content-center align-items-center text-color flex-column my-5 ">
            <?php foreach($commentReviews as $commentReview):?>
                <div class="comment d-flex flex-column align-items-start my-2 bg-reviews w-reviews p-2 rounded-2  ">
                    <div class="userName-stars d-flex gap-2 bg-reviews-top align-items-center mb-1">
                        <img src="./assets/default/image.png" width="36" height="36" alt="">
                        <p class="mb-0"><?= $commentReview->userFirstName?></p>
                        <p class="mb-0"><?= $commentReview->productReview->GetStars(); ?> </p>
                        <i class="fas fa-star color-star"></i>
                    </div>
                    <?php if(isset($commentReview->productComment)):?>
                    <div class="user-comment bg-reviews-bot pt-2">
                        <p class="px-3"><?= $commentReview->productComment->getComment(); ?></p>
                    </div>
                    <?php endif;?>
                </div>
            <?php endforeach;?>
        </div>
        <?php endif;?>

    </div>

    <?php include './includes/rightAdWrapper.php' ?>

   
</div>
<?php include './includes/productimage.php'?>
<?php endif;?>
<?php include './includes/footer.php'; ?>
<script>
    // Fixed benchmark logging
    <?php if(!empty($benchmarks)): ?>
        <?php foreach($benchmarks as $benchmark): ?>
            console.log("<?= addslashes($benchmark) ?>");
        <?php endforeach; ?>
    <?php else: ?>
        console.log("No benchmarks available");
    <?php endif; ?>
</script>

<script>
    const reviewForm = document.getElementById('reviewForm');
    
    function Review(){
        <?php if(!isset($_SESSION['user'])): ?>
            window.location = "./login.php";
            return;
        <?php $_SESSION['message']="Vous devez être connecté pour mettre un avis";
        endif; ?>
        
        if(reviewForm.classList.contains('d-none')){
            reviewForm.classList.remove('d-none');
        }
    }

    reviewForm.addEventListener('submit', async function (e){
        e.preventDefault();
        loading(true);
        const form = e.target;
        const formData = new FormData(form);

        let data = Object.fromEntries(formData.entries());
        <?php if(isset($_SESSION['user'])): ?>
            data.user_id = <?= $_SESSION['user']->GetId() ?>;
        <?php endif; ?>
        data.product_id = <?= $product_id ?>;

        if(!data.stars || data.stars<1 || data.stars >5){
            showMessage("les étoiles attribuées ne sont pas dans la plage accéptée", true);
            loading(false);
            return;
        }
    
        const url = "../back/makeReview.php";
        
        try{
            const res = await myFetch(url, 'POST', data);
            const result = await res.json();
            const stringResult = JSON.stringify(result);
            
            if(res.ok){
                showMessage(result.message || 'Inscription réussie 🎉', false);
                loading(false);
                form.reset();
            }else{
                showMessage(result.error ||'Erreur inconnue', true);
                loading(false);
            }
        }catch(err){
            showMessage('Erreur lors de la requête : ' + err.message, true);
            loading(false);
        }
    });
    

    async function myFetch(url, method, data){
        const res = await fetch(url,{
            method: method,
            headers:{
                'Content-Type':'application/json'
            },
            body: JSON.stringify(data)
        });
        return res;
    }

    function showMessage(msg, isError = false) {
        const div = document.getElementById('msg');
        div.innerHTML = msg.replace(/,/g, '<br>');
        div.style.color = isError ? 'red' : 'green';
    }

    function loading(isLoading) {
        const element = document.getElementById('submit-button');
        if (isLoading) {
            if (typeof originalBtnText === 'undefined') {
                window.originalBtnText = element.textContent;
            }
            element.textContent = "Chargement...";
            element.disabled = true;
        } else {
            element.textContent = window.originalBtnText || "Enregistrer l'avis";
            element.disabled = false;
        }
    }
</script>
</body>

 
</html>