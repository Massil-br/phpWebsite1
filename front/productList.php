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
                    <h5 class="offcanvas-title underline-title text-white" id="subcategoryLabel">Sous Catégories</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body   underline-text" >
                    <div class="d-flex flex-column ">
                        <a class="text-decoration-none text-white nav-link" href="./category/subcategory/products">T-shirts</a>
                        <a class="text-decoration-none text-white nav-link" href="./category/subcategory/products">Pantalons</a>
                        <a class="text-decoration-none text-white nav-link" href="./category/subcategory/products">Shorts</a>
                        <a class="text-decoration-none text-white nav-link" href="./category/subcategory/products">Robes</a>
                        <a class="text-decoration-none text-white nav-link" href="./category/subcategory/products">sweatShirts</a>
                        <a class="text-decoration-none text-white nav-link" href="./category/subcategory/products">casquettes</a>

                    </div>

                </div>
            </div>


            

            <div class="offcanvas offcanvas-start " tabindex="-1" id="Filter" aria-labelledby="FilterLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title underline-title text-white" id="FilterLabel">Filtres</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body   underline-text" >
                    
                    <div class="dropdown me-3 mb-3">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownFilter1" data-bs-toggle="dropdown" aria-expanded="false">
                            Genre
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark bg-white" aria-labelledby="dropdownFilter1" style="min-width: 220px;">
                            <li>
                            <div class="form-check dropdown-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="filter1Options" id="filter1Option0" value="none" checked />
                                <label class="form-check-label mb-0  text-black" for="filter1Option0">Désactivé</label>
                            </div>
                            </li>
                            <li>
                            <div class="form-check dropdown-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="filter1Options" id="filter1Option1" value="hommes" />
                                <label class="form-check-label mb-0  text-black" for="filter1Option1">Vêtements Hommes</label>
                            </div>
                            </li>
                            <li>
                            <div class="form-check dropdown-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="filter1Options" id="filter1Option2" value="femmes" />
                                <label class="form-check-label mb-0  text-black" for="filter1Option2">Vêtements Femmes</label>
                            </div>
                            </li>
                        </ul>
                    </div>

                    <div class="dropdown me-3 mb-3">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownFilter2" data-bs-toggle="dropdown" aria-expanded="false">
                            Couleur
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark bg-white" aria-labelledby="dropdownFilter2" style="min-width: 220px;">
                            <li>
                            <div class="form-check dropdown-item d-flex align-items-center ">
                                <input class="form-check-input me-2 " type="radio" name="filter2Options" id="filter2Option0" value="none" checked />
                                <label class="form-check-label mb-0 text-black" for="filter2Option0">Désactivé</label>
                            </div>
                            </li>
                            <li>
                            <div class="form-check dropdown-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="filter2Options" id="filter2Option1" value="rouge" />
                                <label class="form-check-label mb-0  text-black" for="filter2Option1">Rouge</label>
                            </div>
                            </li>
                            <li>
                            <div class="form-check dropdown-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="filter2Options" id="filter2Option2" value="vert" />
                                <label class="form-check-label mb-0  text-black" for="filter2Option2">Vert</label>
                            </div>
                            </li>
                            <li>
                            <div class="form-check dropdown-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="filter2Options" id="filter2Option3" value="bleu" />
                                <label class="form-check-label mb-0  text-black" for="filter2Option3">Bleu</label>
                            </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <button class=" dropdown-toggle btn btn-light m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#Filter" aria-controls="Filter">filtres</button>

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
                
                <div class="col mobile">
                    <div class="mobile-ad">
                        <img src="./assets/polo1.webp" alt="" class="img-cover w-100">
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

                <div class="col mobile">
                    <div class="mobile-ad">
                        <img src="./assets/polo1.webp" alt="" class="img-cover w-100">
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
    <?php include './includes/footer.php'?>
</body>
</html>