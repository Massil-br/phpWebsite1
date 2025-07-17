<?php
require_once  '../back/getData.php';
$subcategories = []; 
$productCards = [];

if (isset($_GET['category'])) {
    $categoryId = (int) $_GET['category'];
    if ($categoryId <= 0) {
        $categoryId = null;
    }
    $response = GetData(['action'=>'getsubcategories','categoryid' => $categoryId]);
    $subcategories = $response['subcategories'] ?? [];

    if (isset($_GET['subcategory'])){
        $subcategoryId = (int) $_GET['subcategory'];
        $response = GetData(['action' => 'getproductcard', 'param' => 'subcategory', 'id'=> $subcategoryId]);
        
        if (isset($response['error'])){
            var_dump($response['error']);
        } else {
            /**
             * @var ProductCard[]
             */
            $productCards = $response['productCards'];
        }
        
    } else {
        $categoryId = (int)$categoryId;
        $response = GetData(['action' => 'getproductcard', 'param' => 'category', 'id'=> $categoryId]);
        if (isset($response['error'])){
            var_dump($response['error']);
        } else {
            /**
             * @var ProductCard[]
             */
            $productCards = $response['productCards'];
        }
    }

} elseif(isset($_GET['research'])){
    $input = $_GET['research'] ?? '';
    $response = GetData(['action'=> 'search', 'input' =>$input]);
    if (isset($response['error'])){
        var_dump($response['error']);
    } else {
        /**
         * @var ProductCard[]
         */
        $productCards = $response['productCards'];
    }
} else {
    $categoryId = null;
}

if (isset($productCards)) {
    $attributesIds = [];
    $attributesValuesByAttributeId = [];
    foreach ($productCards as $productCard) {
        foreach ($productCard->variantAttributes as $variantAttribute) {
            $attributeId = $variantAttribute->GetAttributeId();
            $value = $variantAttribute->GetValue();

            if (!in_array($attributeId, $attributesIds)) {
                $attributesIds[] = $attributeId;
            }

            if (!isset($attributesValuesByAttributeId[$attributeId])) {
                $attributesValuesByAttributeId[$attributeId] = [];
            }

            if (!in_array($value, $attributesValuesByAttributeId[$attributeId])) {
                $attributesValuesByAttributeId[$attributeId][] = $value;
            }
        }
    }
    $response = GetData(['action' => 'getAttributesById', 'ids' => $attributesIds]);
    if (isset($response['error'])){
        var_dump($response['error']);
    } else {
        $attributes = $response['attributes'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Product List</title>
    <link rel="stylesheet" href="./static/style.css" />
</head>
<body>
    <?php include './includes/header.php' ?>
    <div id="main">
        <div class="left-ad-wrapper">
            <div class="left-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100" />
            </div>
        </div>

        <div class="center">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="subcategory" aria-labelledby="subcategoryLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title underline-title text-color" id="subcategoryLabel">Sous Catégories</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body underline-text">
                    <div class="d-flex flex-column">
                        <?php 
                        /** @var SubCategory[] $subcategories */
                        foreach($subcategories as $subcategory): ?>
                        <a class="text-decoration-none text-color nav-link" href="./productList.php?category=<?= urlencode($categoryId) ?>&subcategory=<?= urlencode($subcategory->GetId()) ?>">
                            <?= htmlspecialchars($subcategory->GetName()) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="dropdown m-3" data-bs-auto-close="outside">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownFilters" data-bs-toggle="dropdown" aria-expanded="false">
                    Filtres
                </button>
                <div class="dropdown-menu p-3 scrollable-dropdown" aria-labelledby="dropdownFilters" style="min-width: 300px;">
                    <h6 class="dropdown-header"><strong>Trier par</strong></h6>
                    <div class="form-check mb-2">
                        <input type="radio" name="sortOption" id="sortOption0" value="nofilter" checked class="form-check-input" />
                        <label for="sortOption0" class="form-check-label">Pertinence</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" name="sortOption" id="sortOption1" value="priceAsc" class="form-check-input" />
                        <label for="sortOption1" class="form-check-label">Prix croissant</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" name="sortOption" id="sortOption2" value="priceDesc" class="form-check-input" />
                        <label for="sortOption2" class="form-check-label">Prix décroissant</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" name="sortOption" id="sortOption3" value="dateAsc" class="form-check-input" />
                        <label for="sortOption3" class="form-check-label">Date d'ajout croissant</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" name="sortOption" id="sortOption4" value="dateDesc" class="form-check-input" />
                        <label for="sortOption4" class="form-check-label">Date d'ajout décroissant</label>
                    </div>

                    <?php if (isset($attributes) && isset($attributesValuesByAttributeId)): ?>
                        <?php foreach ($attributes as $attribute): ?>
                            <h6 class="dropdown-header"><strong><?= htmlspecialchars($attribute->GetName()) ?></strong></h6>

                            <div class="form-check mb-2">
                                <input type="radio"
                                       name="filter_<?= htmlspecialchars($attribute->GetId()) ?>"
                                       id="filter_<?= htmlspecialchars($attribute->GetId()) ?>_none"
                                       value=""
                                       checked
                                       class="form-check-input" />
                                <label for="filter_<?= htmlspecialchars($attribute->GetId()) ?>_none" class="form-check-label">
                                    Ne pas filtrer
                                </label>
                            </div>

                            <?php if (!empty($attributesValuesByAttributeId[$attribute->GetId()])): ?>
                                <?php foreach ($attributesValuesByAttributeId[$attribute->GetId()] as $value): ?>
                                    <div class="form-check mb-2">
                                        <input type="radio"
                                               name="filter_<?= htmlspecialchars($attribute->GetId()) ?>"
                                               id="filter_<?= htmlspecialchars($attribute->GetId()) ?>_<?= htmlspecialchars($value) ?>"
                                               value="<?= htmlspecialchars($value) ?>"
                                               class="form-check-input" />
                                        <label for="filter_<?= htmlspecialchars($attribute->GetId()) ?>_<?= htmlspecialchars($value) ?>" class="form-check-label">
                                            <?= htmlspecialchars($value) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">Aucune valeur disponible</p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4 p-3 justify-content-center">
                <?php foreach ($productCards as $productCard): ?>
                    <?php
                    $variantAttributesArray = [];
                    foreach ($productCard->variantAttributes as $variantAttribute) {
                        $variantAttributesArray[] = [
                            'attribute_id' => $variantAttribute->GetAttributeId(),
                            'value' => $variantAttribute->GetValue()
                        ];
                    }
                    $jsonAttributes = htmlspecialchars(json_encode($variantAttributesArray));
                    ?>
                    <div class="col product-card" data-attributes='<?= $jsonAttributes ?>' 
                         data-price="<?= htmlspecialchars($productCard->variant->GetPrice()) ?>"
                         data-date="<?= htmlspecialchars($productCard->product->GetCreatedAt() ?? '') ?>">
                        <div class="card rounded-5">
                            <a class="text-decoration-none text-color-light-bg" href="./product.php?id=<?= urlencode($productCard->product->GetId()) ?>">
                                <img loading="lazy" src="<?= htmlspecialchars($productCard->variantImage->GetRelativeUrl()) ?>" class="card-img-top h-300px img-cover rounded-5" alt="..." />
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($productCard->product->GetName()) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($productCard->product->GetDescription()) ?></p>
                                    <p class="card-text" style="color: red; font-size: 2rem;">
                                        <strong><?= htmlspecialchars($productCard->variant->GetPrice()) ?> €</strong>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="right-ad-wrapper">
            <div class="right-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100" />
            </div>
        </div>
    </div>

    <?php include './includes/footer.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownMenu = document.querySelector('#dropdownFilters + .dropdown-menu');
            if (dropdownMenu) {
                dropdownMenu.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const productCards = document.querySelectorAll('.product-card');
            const filterRadios = document.querySelectorAll('.form-check-input');

            filterRadios.forEach(radio => {
                radio.addEventListener('change', updateFilters);
            });

            function updateFilters() {
                const activeFilters = {};
                let activeSort = 'nofilter';

                
                const sortRadio = document.querySelector('input[name="sortOption"]:checked');
                if (sortRadio) {
                    activeSort = sortRadio.value;
                }

               
                const filterGroups = new Set();
                filterRadios.forEach(radio => {
                    if (radio.name.startsWith('filter_')) {
                        filterGroups.add(radio.name);
                    }
                });

                filterGroups.forEach(groupName => {
                    const checked = document.querySelector(`input[name="${groupName}"]:checked`);
                    if (checked && checked.value !== '') {
                        activeFilters[groupName] = checked.value;
                    }
                });

                
                productCards.forEach(card => {
                    const jsonString = card.getAttribute('data-attributes');
                    if (jsonString) {
                        try {
                            const variants = JSON.parse(jsonString); 
                            let visible = false;

                            let allFiltersMatch = true;
                            for (const [filterName, filterValue] of Object.entries(activeFilters)) {
                                const attrId = filterName.replace('filter_', '');
                                const found = variants.find(attr => attr.attribute_id == attrId && attr.value == filterValue);
                                if (!found) {
                                    allFiltersMatch = false;
                                    break;
                                }
                            }
                            visible = allFiltersMatch;

                            card.style.display = visible ? '' : 'none';

                        } catch (e) {
                            console.error('Erreur JSON parse :', e);
                            card.style.display = '';
                        }
                    }
                });

                sortCards(activeSort);
            }

            function sortCards(sortOption) {
                const container = document.querySelector('.row.row-cols-1');
                const cardsArray = Array.from(container.children).filter(card => card.style.display !== 'none');

                cardsArray.sort((a, b) => {
                    const aPrice = parseFloat(a.getAttribute('data-price')) || 0;
                    const bPrice = parseFloat(b.getAttribute('data-price')) || 0;

                    const aDateStr = a.getAttribute('data-date');
                    const bDateStr = b.getAttribute('data-date');
                    const aDate = aDateStr ? new Date(aDateStr).getTime() : 0;
                    const bDate = bDateStr ? new Date(bDateStr).getTime() : 0;

                    switch (sortOption) {
                        case 'priceAsc':
                            return aPrice - bPrice;
                        case 'priceDesc':
                            return bPrice - aPrice;
                        case 'dateAsc':
                            return aDate - bDate;
                        case 'dateDesc':
                            return bDate - aDate;
                        default:
                            return 0;
                    }
                });

                cardsArray.forEach(card => container.appendChild(card));
            }
        });
    </script>
</body>
</html>
