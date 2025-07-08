<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="./static/style.css">

</head>
<body>
    <?php include './includes/header.php'?>
    <div id="main">

        <div class="left-ad-wrapper">
            <div class="left-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100">
            </div>
        </div>


        <div class="center">
            <div class="offcanvas offcanvas-start " tabindex="-1" id="subcategory" aria-labelledby="subcategoryLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title underline-title text-color" id="subcategoryLabel">Sous Catégories</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body   underline-text" >
                    <div class="d-flex flex-column ">
                        <a class="text-decoration-none text-color nav-link" href="./category/subcategory/products">T-shirts</a>
                        <a class="text-decoration-none text-color nav-link" href="./category/subcategory/products">Pantalons</a>
                        <a class="text-decoration-none text-color nav-link" href="./category/subcategory/products">Shorts</a>
                        <a class="text-decoration-none text-color nav-link" href="./category/subcategory/products">Robes</a>
                        <a class="text-decoration-none text-color nav-link" href="./category/subcategory/products">sweatShirts</a>
                        <a class="text-decoration-none text-color nav-link" href="./category/subcategory/products">casquettes</a>

                    </div>

                </div>
            </div>


            <div class="dropdown m-3 " data-bs-auto-close="outside">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownFilters" data-bs-toggle="dropdown" aria-expanded="false">
                    Filtres
                </button>
                 <!-- CONTENU DU GROS DROPDOWN -->
                <div class="dropdown-menu p-3 scrollable-dropdown" aria-labelledby="dropdownFilters" style="min-width: 300px;">
                    <!-- Trier par -->
                    <h6 class="dropdown-header"><strong>Trier par</strong></h6>
                    <div class="form-check mb-2">
                        <input type="radio" name="filter0Options" id="filter0Option0" value="none" checked class="form-check-input">
                        <label for="filter0Option0" class="form-check-label">Pertinence</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" name="filter0Options" id="filter0Option1" value="none" class="form-check-input">
                        <label for="filter0Option1" class="form-check-label">Prix croissant</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" name="filter0Options" id="filter0Option2" value="none" class="form-check-input">
                        <label for="filter0Option2" class="form-check-label">Prix décroissant</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" name="filter0Options" id="filter0Option3" value="none" class="form-check-input">
                        <label for="filter0Option3" class="form-check-label">Date d'ajout croissant</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" name="filter0Options" id="filter0Option4" value="none" class="form-check-input">
                        <label for="filter0Option4" class="form-check-label">Date d'ajout décroissant</label>
                    </div>
                                    
                    <!-- GENRE -->
                    <h6 class="dropdown-header"><strong>Genre</strong></h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="filter1Options" id="filter1Option0" value="none" checked>
                        <label class="form-check-label" for="filter1Option0">Désactivé</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="filter1Options" id="filter1Option1" value="hommes">
                        <label class="form-check-label" for="filter1Option1">Vêtements Hommes</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="filter1Options" id="filter1Option2" value="femmes">
                        <label class="form-check-label" for="filter1Option2">Vêtements Femmes</label>
                    </div>

                    <!-- COULEUR -->
                    <h6 class="dropdown-header"><strong>Couleur</strong></h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="filter2Options" id="filter2Option0" value="none" checked>
                        <label class="form-check-label" for="filter2Option0">Désactivé</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="filter2Options" id="filter2Option1" value="rouge">
                        <label class="form-check-label" for="filter2Option1">Rouge</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="filter2Options" id="filter2Option2" value="vert">
                        <label class="form-check-label" for="filter2Option2">Vert</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter2Options" id="filter2Option3" value="bleu">
                        <label class="form-check-label" for="filter2Option3">Bleu</label>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4 p-3">
                <div class="col">
                    <div class="card rounded-5">
                        <a class="text-decoration-none text-color-light-bg" href="./products/id">
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
                        <a class="text-decoration-none text-color-light-bg" href="./products/id">
                        <img src="./assets/chaussure1.webp" class="card-img-top h-300px img-cover rounded-5" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">Chaussure</h5>
                        <p class="card-text">idéalement en jaune, mais peut prendre différentes couleurs</p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong>199$</strong></p>
                        </div>
                        </a>
                    </div>
                </div>
                
                <div class="col mobile">
                    <div class="mobile-ad">
                        <img src="./assets/polo1.webp" alt="" class="img-cover w-100">
                    </div>
                </div>
            

                <div class="col">
                    <div class="card rounded-5">
                        <a class="text-decoration-none text-color-light-bg" href="./products/id">
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
                        <a class="text-decoration-none text-color-light-bg" href="./products/id">
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
                        <a class="text-decoration-none text-color-light-bg" href="./products/id">
                        <img src="./assets/chaussure1.webp" class="card-img-top h-300px img-cover rounded-5" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">Chaussure</h5>
                        <p class="card-text">idéalement en jaune, mais peut prendre différentes couleurs</p>
                        <p class="card-text" style="color: red; font-size: 2rem;"><strong>199$</strong></p>
                        </div>
                        </a>
                    </div>
                </div>

                <div class="col mobile">
                    <div class="mobile-ad">
                        <img src="./assets/polo1.webp" alt="" class="img-cover w-100">
                    </div>
                </div>

                <div class="col">
                    <div class="card rounded-5">
                        <a class="text-decoration-none text-color-light-bg" href="./products/id">
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
    <?php include './includes/footer.php'?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownMenu = document.querySelector('#dropdownFilters + .dropdown-menu');
            if (dropdownMenu) {
            dropdownMenu.addEventListener('click', (e) => {
                e.stopPropagation();
            });
            }
        });
    </script>
</body>
</html>