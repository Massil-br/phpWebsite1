
<script>
// Images du produit
    const images = [
        <?php foreach($productDetail->variantImages as $image):?>
        '<?= htmlspecialchars($image->GetRelativeUrl())?>',
        <?php endforeach;?>
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