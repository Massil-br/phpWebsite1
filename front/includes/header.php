


<!-- header  -->
 <canvas id="background"></canvas>
<header class="headContainer" id="headContainer">
    <!-- top header -->
    <div class="flex-container top-header">
        <div class="left">
            <a href="./index.php" class="logo-link">
                <img src="./assets/logo.png" alt="company-logo" class="logo-img">
            </a>
        </div>
        <nav class="nav-links" id="navlinks">
            <a class="navItem" href="./index.php">HOME</a>
            <a class="navItem" href="./categoryList.php">CATEGORY LIST</a>
            <a class="navItem" href="./product.php">PRODUCT</a>
            <a class="navItem" href="./productList.php">PRODUCT LIST</a>
            <div class="searchBar flex-container">
                <form action="./back/research.php" method="post">
                    <input type="search" name="research" placeHolder=" Search..." aria-label="Research" required>
                    <button class="search-button" type="submit"><img src="./assets/searchLogo.png" alt="research-button"></button>
                </form>
            </div>
        </nav>

        
        <div class="right">
            <a href="./profile.php" class="icon-link">
                <img src="./assets/accountIcon.png" alt="accountIcon">
            </a>
            <a href="./cart.php" class="icon-link">
                <img src="./assets/cartIcon.png" alt="accountIcon">
            </a>
        </div>

        <button id="hamburgerBtn" class="hamburger-btn" aria-label="Toggle menu">
        ≡
        </button>
        
    </div>
   


    
</header>