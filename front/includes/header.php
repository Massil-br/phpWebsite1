
<?php
    require_once '../back/getData.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $response = GetData(['action'=>'getcategories']);
    /**
     * @var Category[] $categories
     */
    $categories = $response['categories'];
    
    
?>

<!-- header  -->
 <canvas id="background"></canvas>
 
<header>
    <nav class="navbar navbar-expand-lg " data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">
                <img class="max-size-48px" src="./assets/logo.png" alt="Accueil">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./index.php">Accueil</a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle active" data-bs-toggle="offcanvas" href="#categories-offcanvas" role="button" aria-controls="categories-offcanvas">
                    Categories
                    </a>
                </li>

                <?php 
                    $page = basename($_SERVER['SCRIPT_FILENAME']);
                    if ($page === "productList.php" && !isset($_GET['research'])){
                        echo '
                            <li class="nav-item dropdown ">
                                <a class="nav-link dropdown-toggle active" data-bs-toggle="offcanvas" href="#subcategory" role="button" aria-controls="subcategory">
                                    Sous Catégories
                                </a>
                            </li>
                        ';
                    }
                ?>
            </ul>
            <form class="d-flex me-5" role="search" method="GET" action="./productList.php">
                <input 
                class="form-control me-2"
                type="search"
                name="research"
                placeholder="Recherche"
                aria-label="Recherche"
                />
                <button class="btn btn-outline-success" type="submit">Rechercher</button>
            </form>
            <ul class="navbar-nav me-5 mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./cart.php">Panier</a>
                </li>
                <?php if(!isset($_SESSION['user'])):?>
                <li>
                    <a class="nav-link active" aria-current="page" href="./login.php">Se connecter</a>
                </li>
                <li>
                    <a class="nav-link active" aria-current="page" href="./register.php">S'inscrire</a>
                </li>
                <?php  else:?>
                <li>
                <a class="nav-link active" aria-current="page" href="./profile.php"><?= $_SESSION['user']->getFirstName() ?></a>
                </li>
                <li>
                    <a class="nav-link active" aria-current="page" href="./logout.php">Se déconnecter</a>
                </li>
                <?php endif;?>
            </ul>
            </div>
        </div>
    </nav>

    
    <div class="offcanvas offcanvas-top "  tabindex="-1" id="categories-offcanvas" aria-labelledby="categories-offcanvas-label">
    <div class="offcanvas-header ">
        <h5 class="offcanvas-title underline-title text-white" id="categories-offcanvas-label">Catégories</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body offcanvas-row underline-text " >

        <?php foreach($categories as $category): ?>
            <a class="text-decoration-none text-color nav-link scale-on-hover"
       href="./productList.php?category=<?= urlencode($category->GetId()) ?>">  <?= htmlspecialchars($category->GetName()) ?></a>
     <?php endforeach;?>
        
            
    </div>

</header>
   


    
