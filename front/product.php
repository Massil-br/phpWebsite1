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
<?php require_once './includes/header.php';?>
<div id="main">
    <div class="left-ad-wrapper">
        <div class="left-ad">
            <img src="./assets/shoes.png" alt="" class="img-cover w-100">
        </div>
    </div>

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
                            <img id="main-image" src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=400&fit=crop" alt="Nike Air Max 270" class="main-image">
                            
                            <div class="thumbnail-container">
                                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=80&h=80&fit=crop" alt="Vue 1" class="thumbnail active" data-index="0">
                                <img src="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=80&h=80&fit=crop" alt="Vue 2" class="thumbnail" data-index="1">
                                <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?w=80&h=80&fit=crop" alt="Vue 3" class="thumbnail" data-index="2">
                                <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=80&h=80&fit=crop" alt="Vue 4" class="thumbnail" data-index="3">
                                <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=80&h=80&fit=crop" alt="Vue 5" class="thumbnail" data-index="4">
                            </div>
                        </div>
                    </div>

                    <!-- Informations produit -->
                    <div class="col-lg-6 col-md-12">
                        <div class="product-info">
                            <h1 class="product-title">Nike Air Max 270</h1>
                            <div class="product-price">129,99 €</div>
                            
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
                                La Nike Air Max 270 offre un confort exceptionnel avec sa technologie Air Max visible et son design moderne. Parfaite pour un usage quotidien avec style.
                            </p>

                            <div class="size-selector">
                                <label class="form-label fw-bold text-color">Taille:</label>
                                <div class="d-flex flex-wrap">
                                    <button class="size-btn" data-size="38">38</button>
                                    <button class="size-btn" data-size="39">39</button>
                                    <button class="size-btn active" data-size="40">40</button>
                                    <button class="size-btn" data-size="41">41</button>
                                    <button class="size-btn" data-size="42">42</button>
                                    <button class="size-btn" data-size="43">43</button>
                                    <button class="size-btn" data-size="44">44</button>
                                    <button class="size-btn" data-size="45">45</button>
                                </div>
                            </div>

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
    </div>

    <div class="left-ad-wrapper">
        <div class="left-ad">
            <img src="./assets/shoes.png" alt="" class=" img-cover w-100">
        </div>
    </div>

   
</div>
    
<?php require_once './includes/footer.php'; ?>

</body>

 <script>
        // Images du produit
        const images = [
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=600&h=400&fit=crop'
        ];

        let currentImageIndex = 0;
        let selectedSize = 40;
        let isZoomed = false;

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('total-images').textContent = images.length;
            
            // Gestion des miniatures
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach((thumbnail, index) => {
                thumbnail.addEventListener('click', () => changeImage(index));
            });

            // Gestion des tailles
            const sizeButtons = document.querySelectorAll('.size-btn');
            sizeButtons.forEach(btn => {
                btn.addEventListener('click', () => selectSize(btn.dataset.size));
            });

            // Agrandissement de l'image principale
            document.getElementById('main-image').addEventListener('click', openModal);

            // Fermeture du modal avec Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeModal();
                if (e.key === 'ArrowLeft') changeModalImage(-1);
                if (e.key === 'ArrowRight') changeModalImage(1);
            });
        });

        function changeImage(index) {
            currentImageIndex = index;
            document.getElementById('main-image').src = images[index];
            document.getElementById('current-image').textContent = index + 1;
            
            // Mise à jour des miniatures
            document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        }

        function selectSize(size) {
            selectedSize = size;
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.size === size);
            });
        }

        function changeQuantity(delta) {
            const input = document.getElementById('quantity');
            const newValue = parseInt(input.value) + delta;
            if (newValue >= 1 && newValue <= 10) {
                input.value = newValue;
            }
        }

        function openModal() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            
            modal.style.display = 'block';
            modalImage.src = images[currentImageIndex];
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            
            modal.style.display = 'none';
            modalImage.classList.remove('zoomed');
            isZoomed = false;
            document.body.style.overflow = 'auto';
        }

        function changeModalImage(delta) {
            currentImageIndex += delta;
            if (currentImageIndex < 0) currentImageIndex = images.length - 1;
            if (currentImageIndex >= images.length) currentImageIndex = 0;
            
            document.getElementById('modalImage').src = images[currentImageIndex];
            document.getElementById('modalImage').classList.remove('zoomed');
            isZoomed = false;
            
            // Mise à jour de l'image principale et des miniatures
            changeImage(currentImageIndex);
        }

        // Zoom sur l'image dans le modal
        document.getElementById('modalImage').addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('zoomed');
            isZoomed = !isZoomed;
        });

        // Fermeture du modal en cliquant sur l'arrière-plan
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function addToCart() {
            const quantity = document.getElementById('quantity').value;
            alert(`Produit ajouté au panier!\nTaille: ${selectedSize}\nQuantité: ${quantity}`);
            
            // Animation du bouton
            const btn = document.querySelector('.add-to-cart-btn');
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Ajouté au panier!';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Ajouter au panier';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
            }, 2000);
        }

        function addToWishlist() {
            alert('Produit ajouté à la liste de souhaits!');
            
            // Animation du bouton
            const btn = document.querySelector('.btn-outline-secondary');
            const icon = btn.querySelector('i');
            icon.classList.remove('fas', 'fa-heart');
            icon.classList.add('fas', 'fa-heart');
            icon.style.color = '#dc3545';
            
            setTimeout(() => {
                icon.style.color = '';
            }, 2000);
        }
    </script>
</html>