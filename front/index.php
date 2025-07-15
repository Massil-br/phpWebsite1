<?php
    require_once   '../back/getData.php';
    $response = GetData(['action' => 'getHomeCategories']);
    if(isset($response['error'])){
        var_dump($response['error']);
    }else{
        $homeCategories  = $response['homeCategories'];
    }

    $response = GetData(['action' => 'gethomeproducts', 'limit'=> 6]);
    if(isset($response['error'])){
        var_dump($response['error']);
    }else{
        $homeProductCards = $response['homeProductCards'];
    }

    $response = GetData(['action' =>'gethomeproducts','limit' => 3]);
    if(isset($response['error'])){
        var_dump($response['error']);
    }else{
        $carouselProductCards = $response['homeProductCards'];
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
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
            <div class="d-flex align-items-center justify-content-center mx-4  pt-3 gap-4 flex-wrap ">
                <div id="mainPageCarousel" class=" carousel slide   caroussel-max-height-500px ">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#mainPageCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#mainPageCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#mainPageCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    </div>
                    <div class="carousel-inner  ">
                        <?php if(isset($carouselProductCards)):?>
                            <div class="carousel-item active  ">
                            <a  class="d-flex align-items-center justify-content-center" href="./product.php?id=<?= $carouselProductCards[0]->product->GetId() ?>">
                                <img src="<?= $carouselProductCards[0]->variantImage->GetRelativeUrl() ?>" class="d-block  carousel-img-fixed" alt="<?= $carouselProductCards[0]->variantImage->GetAlt() ?>">
                                <div class="carousel-caption d-none d-md-block ">
                                    <h5 class="card-title text-black d-flex justify-content-center">
                                    <strong class="bg-white rounded-2 p-1"><?= $carouselProductCards[0]->product->GetName() ?></strong>
                                    </h5>
                                </div>
                            </a>
                            </div>
                           <?php for($i = 1; $i < count($carouselProductCards);$i++): ?>
                             <div class="carousel-item ">
                            <a class="d-flex align-items-center justify-content-center" href="./product.php?id=<?= $carouselProductCards[$i]->product->GetId() ?>">
                                <img src="<?= $carouselProductCards[$i]->variantImage->GetRelativeUrl() ?>" class="d-block  carousel-img-fixed" alt="<?= $carouselProductCards[$i]->variantImage->GetAlt() ?>">
                                <div class="carousel-caption d-none d-md-block ">
                                    <h5 class="card-title text-black d-flex justify-content-center">
                                    <strong class="bg-white rounded-2 p-1"><?= $carouselProductCards[$i]->product->GetName() ?></strong>
                                    </h5>
                                </div>
                            </a>
                            </div>
                        <?php endfor; endif;?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainPageCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-black" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainPageCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-black" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="mobile-ad">
                <img src="./assets/robe1.webp" alt="" class="img-cover w-100">
            </div>



            <!-- catégories recommandées-->
            <div class="d-flex align-items-center justify-content-center  text-black mt-3 ">
                <h1 class="text-white">Catégories recommandées</h1>
            </div>

            
           <div class="row row-cols-1 row-cols-md-3 g-4 p-3">
            <?php if(isset($homeCategories)):
                foreach($homeCategories as $homeCategory):?>
                <!-- Carte 1 -->
                <div class="col">
                    <div class="card text-bg-white rounded-3">
                        <a class="text-decoration-none text-black" href="./productList.php?category=<?= urlencode($homeCategory->category->GetId()) ?>">
                        <img src="<?= $homeCategory->variantImage->GetRelativeUrl() ?>" class="card-img h-300px img-cover" alt="...">
                        <div class="card-img-overlay">
                            <h5 class="card-title text-black d-flex justify-content-center">
                            <strong class="bg-white rounded-5 p-1"><?= $homeCategory->category->GetName() ?></strong>
                            </h5>
                        </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; endif;?>
                
            </div>


            <div class="mobile-ad">
                <img src="./assets/polo1.webp" alt="" class="img-cover w-100">
            </div>


            <!-- Produits Recommandés-->
            <div class="d-flex align-items-center justify-content-center  text-black mt-3 ">
                <h1 class="text-white">Produits recommandées</h1>
            </div>


            <div class="row row-cols-1 row-cols-md-3 g-4 p-3">
                <?php 
                    if(isset($homeProductCards)):
                        foreach($homeProductCards as $homeProductCard):
                ?>
                <div class="col">
                    <div class="card  rounded-5">
                        <a class="text-decoration-none text-black" href="./product.php?id=<?= urlencode($homeProductCard->product->GetId()) ?>">
                        <img src="<?= $homeProductCard->variantImage->GetRelativeUrl() ?>" class="card-img-top  img-cover  rounded-5 h-300px" alt="...">
                        <div class="card-body">
                        <h5 class="card-title"><?=$homeProductCard->product->GetName() ?></h5>
                        <p class="card-text"><?=$homeProductCard->product->GetDescription() ?></p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong><?=$homeProductCard->variant->GetPrice()?> €</strong></p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endforeach; endif; ?>
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