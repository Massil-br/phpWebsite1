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
    <?php require_once './includes/header.php'; ?>
    
   

        
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
                    <div class="carousel-inner ">
                        <div class="carousel-item active  ">
                        <img src="./assets/robe1.webp" class="d-block  carousel-img-fixed" alt="...">
                        <div class="carousel-caption d-none d-md-block ">
                            <h5>Robe rouge</h5>
                            <p>Découvrez nos nouvelles robes de soirées</p>
                        </div>
                        </div>
                        <div class="carousel-item">
                        <img src="./assets/polo1.webp" class="d-block  carousel-img-fixed" alt="...">
                        <div class="carousel-caption d-none d-md-block text-black">
                            <h5>Polo</h5>
                            <p>L'été est arrivé, il est temps de sortir votre nouveau polo</p>
                        </div>
                        </div>
                        <div class="carousel-item ">
                        <img src="./assets/chaussure1.webp" class="d-block  carousel-img-fixed" alt="...">
                        <div class="carousel-caption d-none d-md-block blue text-black">
                            <h5>Chaussure</h5>
                            <p>Quoi de mieux que de nouvelles chaussures légères en ce temps chaud ?</p>
                        </div>
                        </div>
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
                <!-- Carte 1 -->
                <div class="col">
                    <div class="card text-bg-white rounded-3">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/vetementPhoto.webp" class="card-img h-300px img-cover" alt="...">
                        <div class="card-img-overlay">
                            <h5 class="card-title text-black d-flex justify-content-center">
                            <strong class="bg-white rounded-5 p-1">Vetements</strong>
                            </h5>
                        </div>
                        </a>
                    </div>
                </div>

                <!-- Carte 2 -->
                <div class="col">
                    <div class="card text-bg-white rounded-3">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/vetementPhoto.webp" class="card-img h-300px img-cover" alt="...">
                        <div class="card-img-overlay">
                            <h5 class="card-title text-black d-flex justify-content-center">
                            <strong class="bg-white rounded-5 p-1">Meubles</strong>
                            </h5>
                        </div>
                        </a>
                    </div>
                </div>
                
                <!-- Carte 3 -->
                <div class="col">
                    <div class="card text-bg-white rounded-3">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/vetementPhoto.webp" class="card-img h-300px img-cover" alt="...">
                        <div class="card-img-overlay">
                            <h5 class="card-title text-black d-flex justify-content-center">
                            <strong class="bg-white rounded-5 p-1">High Tech</strong>
                            </h5>
                        </div>
                        </a>
                    </div>
                </div>
            </div>


            <div class="mobile-ad">
                <img src="./assets/polo1.webp" alt="" class="img-cover w-100">
            </div>


            <!-- Produits Recommandés-->
            <div class="d-flex align-items-center justify-content-center  text-black mt-3 ">
                <h1 class="text-white">Produits recommandées</h1>
            </div>


            <div class="row row-cols-1 row-cols-md-3 g-4 p-3">
                <div class="col">
                    <div class="card rounded-5">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/chaussure1.webp" class="card-img-top h-300px img-cover  rounded-5" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">Chaussure</h5>
                        <p class="card-text">idéalement en jaune, mais peut prendre différentes couleurs</p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong>199$</strong></p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col">

                    <div class="card rounded-5">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/chaussure1.webp" class="card-img-top h-300px img-cover rounded-5" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">Chaussure</h5>
                        <p class="card-text">idéalement en jaune, mais peut prendre différentes couleurs</p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong>199$</strong></p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-5">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/chaussure1.webp" class="card-img-top h-300px img-cover rounded-5" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">Chaussure</h5>
                        <p class="card-text">idéalement en jaune, mais peut prendre différentes couleurs</p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong>199$</strong></p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-5">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/chaussure1.webp" class="card-img-top h-300px img-cover rounded-5" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">Chaussure</h5>
                        <p class="card-text">idéalement en jaune, mais peut prendre différentes couleurs</p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong>199$</strong></p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-5">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/chaussure1.webp" class="card-img-top h-300px img-cover rounded-5" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">Chaussure</h5>
                        <p class="card-text">idéalement en jaune, mais peut prendre différentes couleurs</p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong>199$</strong></p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-5">
                        <a class="text-decoration-none text-black" href="./products/id">
                        <img src="./assets/chaussure1.webp" class="card-img-top h-300px img-cover rounded-5" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">Chaussure</h5>
                        <p class="card-text">idéalement en jaune, mais peut prendre différentes couleurs</p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong>199$</strong></p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="right-ad-wrapper">
            <div class="right-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100">
            </div>
        </div>
    


    </div>
    <?php require_once './includes/footer.php'; ?>
</body>
</html>