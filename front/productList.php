<?php
require_once '../back/getData.php';

$subcategories = []; 
$productCards = [];
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 12;

if (isset($_GET['category'])) {
    $categoryId = (int) $_GET['category'];
    if ($categoryId <= 0) {
        $categoryId = null;
    }

    $response = GetData([
        'action' => 'getsubcategories',
        'categoryid' => $categoryId
    ]);
    $subcategories = $response['subcategories'] ?? [];

    if (isset($_GET['subcategory'])) {
        $subcategoryId = (int) $_GET['subcategory'];

        if (isset($_GET['sortOption']) && $_GET['sortOption'] !== 'nofilter') {
            switch ($_GET['sortOption']) {
                case 'priceAsc':
                    $sortOption = 'priceAsc';
                    break;
                case 'priceDesc':
                    $sortOption = 'priceDesc';
                    break;
                case 'dateAsc':
                    $sortOption = 'dateAsc';
                    break;
                case 'dateDesc':
                    $sortOption = 'dateDesc';
                    break;
                default:
                    echo "error invalid input in url sortOption";
            }
        }

        $filterMap = [
            'filter_1' => FilterName::COLOR,
            'filter_2' => FilterName::SIZE,
        ];

        foreach ($_GET as $key => $value) {
            if (str_starts_with($key, 'filter_') && isset($filterMap[$key])) {
                $name =$filterMap[$key];
                $values = explode(',', $value);
                $values = array_map('trim', $values);
                $filters[] = new Filter($name, $values);
            }
        }

        if (isset($filters) && isset($sortOption)) {
            $response = GetData([
                'action' => 'getproductsbysubcategorypaginatedwithfilters',
                'subcategory_id' => $subcategoryId,
                'page' => $page,
                'limit' => $limit,
                'filters' => $filters,
                'sortOption' => $sortOption
            ]);
        } elseif (isset($filters)) {
            $response = GetData([
                'action' => 'getproductsbysubcategorypaginatedwithfilters',
                'subcategory_id' => $subcategoryId,
                'page' => $page,
                'limit' => $limit,
                'filters' => $filters
            ]);
        } elseif (isset($sortOption)) {
            $response = GetData([
                'action' => 'getproductsbysubcategorypaginatedwithfilters',
                'subcategory_id' => $subcategoryId,
                'page' => $page,
                'limit' => $limit,
                'sortOption' => $sortOption
            ]);
        }else {
            $categoryId = (int) $categoryId;
            $response = GetData([
                'action' => 'Getproductsbysubcategorypaginated',
                'subcategory_id' => $subcategoryId,
                'page' => $page,
                'limit' => $limit
            ]);
        }

        if (isset($response['error'])) {
            var_dump($response['error']);
        } else {
            /**
             * @var ProductCard[]
             */
            $productCards = $response['productCards'];
            $totalPages = $response['totalPages'] ?? 1;
            $currentPage = $response['currentPage'] ?? 1;
            $totalCount = $response['totalCount'] ?? 0;
        }

    } else {
        if (isset($_GET['sortOption']) && $_GET['sortOption'] !== 'nofilter') {
            switch ($_GET['sortOption']) {
                case 'priceAsc':
                    $sortOption = 'priceAsc';
                    break;
                case 'priceDesc':
                    $sortOption = 'priceDesc';
                    break;
                case 'dateAsc':
                    $sortOption = 'dateAsc';
                    break;
                case 'dateDesc':
                    $sortOption = 'dateDesc';
                    break;
                default:
                    echo "error invalid input in url sortOption";
            }
        }

        $filterMap = [
            'filter_1' => FilterName::COLOR,
            'filter_2' => FilterName::SIZE,
        ];

        foreach ($_GET as $key => $value) {
            if (str_starts_with($key, 'filter_') && isset($filterMap[$key])) {
                $name =$filterMap[$key];
                $values = explode(',', $value);
                $values = array_map('trim', $values);
                $filters[] = new Filter($name, $values);
            }
        }

        if (isset($filters) && isset($sortOption)) {
            $response = GetData([
                'action' => 'getproductsbycategorypaginatedwithfilters',
                'category_id' => $categoryId,
                'page' => $page,
                'limit' => $limit,
                'filters' => $filters,
                'sortOption' => $sortOption
            ]);
        } elseif (isset($filters)) {
            $response = GetData([
                'action' => 'getproductsbycategorypaginatedwithfilters',
                'category_id' => $categoryId,
                'page' => $page,
                'limit' => $limit,
                'filters' => $filters
            ]);
        } elseif (isset($sortOption)) {
            $response = GetData([
                'action' => 'getproductsbycategorypaginatedwithfilters',
                'category_id' => $categoryId,
                'page' => $page,
                'limit' => $limit,
                'sortOption' => $sortOption
            ]);
        }else {
            $categoryId = (int) $categoryId;
            $response = GetData([
                'action' => 'Getproductsbycategorypaginated',
                'category_id' => $categoryId,
                'page' => $page,
                'limit' => $limit
            ]);
        }

        if (isset($response['error'])) {
            var_dump($response['error']);
        } else {
            /**
             * @var ProductCard[]
             */
            $productCards = $response['productCards'] ?? [];
            $totalPages = $response['totalPages'] ?? 1;
            $currentPage = $response['currentPage'] ?? 1;
            $totalCount = $response['totalCount'] ?? 0;
        }
    }

} elseif (isset($_GET['research'])) {
    $input = $_GET['research'] ?? '';
    $response = GetData([
        'action' => 'searchPaginated',
        'input' => $input,
        'page' => $page,
        'limit' => $limit
    ]);

    if (isset($response['error'])) {
        var_dump($response['error']);
    } else {
        /**
         * @var ProductCard[]
         */
        $productCards = $response['productCards'] ?? [];
        $totalPages = $response['totalPages'] ?? 1;
        $currentPage = $response['currentPage'] ?? 1;
        $totalCount = $response['totalCount'] ?? 0;
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

    $response = GetData([
        'action' => 'getAttributesByIds',
        'ids' => $attributesIds
    ]);

    if (isset($response['error'])) {
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
            
            <form id="filterForm" method="get" action="productList.php">
                <div class="dropdown m-3" data-bs-auto-close="outside">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownFilters" data-bs-toggle="dropdown" aria-expanded="false">
                        Filtres
                    </button>
                    <div class="dropdown-menu p-3 scrollable-dropdown" aria-labelledby="dropdownFilters" style="min-width: 300px;">
                        <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Appliquer</button>
                        </div>
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
                                <?php if (!empty($attributesValuesByAttributeId[$attribute->GetId()])): ?>
                                    <?php foreach ($attributesValuesByAttributeId[$attribute->GetId()] as $value): ?>
                                        <div class="form-check mb-2">
                                            <input type="checkbox"
                                                name="filter_<?= htmlspecialchars($attribute->GetId())?>"
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
            </form>

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
            
            <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <?php
                        $queryParams = $_GET;
                        $baseUrl = 'productList.php';

                        function buildPageLink($pageNumber) {
                            $queryParams = $_GET;
                            $queryParams['page'] = $pageNumber;
                            return 'productList.php?' . http_build_query($queryParams);
                        }
                    ?>

                    <!-- Page précédente -->
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= buildPageLink($currentPage - 1) ?>">&laquo;</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $range = 2;
                    $start = max(1, $currentPage - $range);
                    $end = min($totalPages, $currentPage + $range);

                    if ($start > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= buildPageLink(1) ?>">1</a>
                        </li>
                        <?php if ($start > 2): ?>
                            <li class="page-item disabled"><span class="page-link">…</span></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="<?= buildPageLink($i) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($end < $totalPages): ?>
                        <?php if ($end < $totalPages - 1): ?>
                            <li class="page-item disabled"><span class="page-link">…</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= buildPageLink($totalPages) ?>"><?= $totalPages ?></a>
                        </li>
                    <?php endif; ?>

                    <!-- Page suivante -->
                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= buildPageLink($currentPage + 1) ?>">&raquo;</a>
                        </li>
                    <?php endif; ?>

                </ul>
                </nav>
            <?php endif; ?>
            
        </div>

        <div class="right-ad-wrapper">
            <div class="right-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100" />
            </div>
        </div>
    </div>

    <?php include './includes/footer.php' ?>
    <script>

        document.querySelectorAll('.dropdown-menu').forEach(menu =>{
            menu.addEventListener('click',function(e){
                e.stopPropagation();
            });
        });


        document.querySelector('#filterForm').addEventListener("submit", function(e){
            e.preventDefault();
            console.log('Soumission interceptée');

            const form = e.target;
            const data ={};

            form.querySelectorAll("input[type=checkbox]:checked").forEach(input =>{
                const name = input.name;
                if (!data[name]) data[name]=[];
                data[name].push(input.value);
            });

            form.querySelectorAll("input[type=radio]:checked").forEach(input =>{
                data[input.name]= input.value;
            });

            params = new URLSearchParams(window.location.search);
            const newParams = new URLSearchParams();

            for (const [key, value] of params.entries()){
                if(!key.startsWith('filter_') && key !== 'sortOption'){
                    newParams.set(key,value);
                }
            }


            for (const name in data){
                if(Array.isArray(data[name])){
                    newParams.set(name, data[name].join(','));
                }else{
                    newParams.set(name,data[name]);
                }
            }

            const baseUrl = window.location.pathname;
            const finalUrl = baseUrl +'?'+ newParams.toString();
            console.log('Redirection vers :' , finalUrl);
            window.location.href = finalUrl;

        });
    </script>

    
</body>
</html>
