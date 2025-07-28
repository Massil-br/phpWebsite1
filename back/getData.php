<?php

require_once(__DIR__ . '/db.php');


function GetData(array $params):array{
    if (empty($params['action'])) {
        return ['error' => 'action must contain a valid action'];
    }

    $params['action'] = strtolower($params['action']);

    switch ($params['action']){
        case 'getcategories':
            return GetCategories();
        case 'getsubcategories':
            return GetSubCategories($params);
        case 'getproductcard':
            return GetProductCards($params);
        case 'getproductdetail':
           return GetProductDetails($params);
        case 'gethomecategories':
            return GetHomeCategories();
        case 'gethomeproducts':
           return GetHomeProducts($params);
        case 'search':
            return Search($params);
        case 'getattributesbyids':
           return GetAttributesById($params);
        case 'getproductsbycategorypaginated':
           return GetProductsByCategoryPaginated($params);
        case 'getproductsbysubcategorypaginated':
            return GetProductsBySubcategoryPaginated($params);
        case 'searchpaginated':
            return SearchPaginated($params);
        case 'searchpaginatedwithfilters':
            return SearchPaginatedWithFilters($params);
        case 'getproductsbycategorypaginatedwithfilters':
            return GetProductsByCategoryPaginatedWithFilters($params);
        case'getproductsbysubcategorypaginatedwithfilters':
            return GetProductsBySubcategoryPaginatedWithFilters($params);
        case 'getattrvattrbycategory':
            return GetAttrVAttrByCategory($params);
        case 'getattrvattrbysubcategory':
            return GetAttrVAttrBySubcategory($params);
        case 'getattrvattrbysearch':
            return GetAttrVAttrBySearch($params);
        default:
            return ['error' => 'Unknown action'];
    }

}

/**
 * Summary of CreateProductCardsWithProductList
 * @param Product[] $products
 * @return ProductCard[]
 */
function CreateProductCardsWithProductList(array $products): array {
    global $db;
    $firstVariants = [];
    $productImages = [];
    $allvariantsAttributesByProduct = [];
            
    foreach ($products as $product) {
        try {
            $variant = ProductVariant::GetFirstVariantByProductId($db,$product->GetId());
            $image = VariantImage::GetProductFirstImage($db,$product->GetId());
            $variantIdList = ProductVariant::GetVariantsIdsByProductId($db,$product->GetId());
            
            $productVariantAttributes = [];
            foreach ($variantIdList as $variantId) {
                $attributes = VariantAttribute::GetVariantAttributes($db,$variantId);
                foreach ($attributes as $attribute) {
                    $productVariantAttributes[] = $attribute;
                }
            }

        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }

        $firstVariants[] = $variant;
        $productImages[] = $image;
        $allvariantsAttributesByProduct[] = $productVariantAttributes;
    }

    $productCards = [];
    for ($i = 0; $i < count($products); $i++) {
        $productCards[] = new ProductCard(
            $products[$i],
            $firstVariants[$i],
            $productImages[$i],
            $allvariantsAttributesByProduct[$i]
        );
        if (empty($productCards[$i])) {
            throw new ErrorException("Error while creating product card at index $i");
        }
    }

    return $productCards;
}



function GetCategories():array{
    global $db;
    $categories = Category::getCategories($db);
    if(empty($categories)){
        return ['error'=>'no categories found'];
    }
    return ['categories' => $categories];
}

function GetSubCategories(array $params):array{
    global $db;
    if (!isset($params['categoryid']) || !is_int($params['categoryid']) || $params['categoryid'] <= 0) {
        return ['error' => 'categoryid is empry or invalid'];
    }

    $subcategories = SubCategory::getSubCategories($db,$params['categoryid']);
    if(empty($subcategories)){
        return ['error' => 'no subcategories found'];
    }
    return ['subcategories' => $subcategories];
}

function GetProductCards( array $params):array{
    global $db;
    if(!isset($params['param'])){
        return ['error'=>'param not set'];
    }
    if (!isset($params['id'])){
        return ['error' => 'id not set'];
    }
    if(!is_int($params['id'])){
        return ['error' => 'id is not int'];
    }
    if ($params['id'] <= 0){
        return ['error' => 'id <= 0'];
    }
    
    
    $params['param'] = strtolower($params['param']);
    if($params['param'] === 'category'){
        try{
            $products = Product::getProductsByCategoryId($db,$params['id']);
            
        }catch(ErrorException $e){
            return ["error" => $e->getMessage()];
        }
        

        $productCards=[];
        try{
            $productCards =  CreateProductCardsWithProductList($products);
        }catch(ErrorException $e){
            return ['error' => $e->getMessage()];
        }
    
    return ['productCards' =>$productCards];
    }
    if ($params['param'] === 'subcategory'){
        global $db;

        $products = Product::getProductsBySubCategoryId($db,$params['id']); 
        if (empty($products)){
            return ['error'=> 'product not found'];
        }

        $productCards=[];
        try{
            $productCards =  CreateProductCardsWithProductList($products);
        }catch(ErrorException $e){
            return ['error' => $e->getMessage()];
        }
        
        return ['productCards' =>$productCards];
    }

    return ['error' => 'invalid param'];
}


function GetProductDetails(array $params):array{
    global $db;
     if(!isset($params['id'])){
        return ['error' =>'missing id param'];
    }
    if (!is_int($params['id'])){
        return ['error' => 'id must be integer'];
    }
    if ($params['id']<= 0){
        return ['error'=> 'id must be positive and higher than 0']; 
    }

    $product =Product::GetProductById($db, $params['id']);
    if(empty($product)){
        return ['error' => 'product not found'];
    }

    $variants= ProductVariant::GetProductVariantsByProductId($db,$product->GetId());
    if(empty($variants)){
        return ['error'=>['no variants found']];
    }
    

    $productImages = VariantImage::GetProductImages($db,$params['id']);
    if(empty($productImages)){
        return ['error' => 'no productImages found'];
    }
    $productAttributes = [];
    foreach($variants as $variant){
        $productAttributes   = VariantAttribute::GetVariantAttributes($db,$variant->GetId());
        if(empty($productAttributes)){
            return ['error'=> 'no product attributes found'];
        }
    }
    

    $ids = [];
    foreach($productAttributes as $p){
        $ids[]= $p->GetAttributeId();
    }

    $attributes =FilterAttribute::GetAttributesByIds($db,$ids);
        if(empty($attributes)){
            return ['error'=> 'no attributes found'];
        }

    $productDetail = new ProductDetail($product,$variants, $productImages, $attributes, $productAttributes);
    if(empty($productDetail)){
        return ['error' => 'could not create productDetail'];
    }

    return['productDetail' => $productDetail];
}

function GetHomeCategories():array{
    global $db;
    $categories=[];
    $homeCategories = [];
    try{
        $categories = Category::Get3RandomCategories($db);
        foreach($categories as $category){
            $variantImage = VariantImage::GetRandImageByCategoryId($db,$category->GetId()); 
            $homeCategories[]= new HomeCategory($category, $variantImage);
        }
    }catch(ErrorException $e){
        return ["error" => $e->getMessage()];
    }
    return ['homeCategories' =>$homeCategories];
}

function GetHomeProducts(array $params):array{
    global $db;
    if(!isset($params['limit'])){
        return ['error' => 'limit param not set'];
    }
    if(!is_int($params['limit'])){
        return ['error' => 'limit param needs to be an integer'];
    }
    if($params['limit']<=0){
        return['error' => 'limit must be positive & higher than 0'];
    }

    $productIds = Product::GetRandomProductsIds($db,$params['limit']);
    $products =[];

    foreach($productIds as $productId){
        $products[]= Product::GetProductById($db,$productId);
    }
    
    $firstVariants = [];
    $productImages= [];
    foreach($products as $product){
        try{
            $variant = ProductVariant::GetFirstVariantByProductId($db,$product->GetId()); 
        }catch(ErrorException $e){
            return ["error" => $e->getMessage(), "products" => $products];
        }
        
        $firstVariants[]= $variant;
        try{
            $image = VariantImage::GetProductFirstImage($db, $product->GetId()); 
        }catch(ErrorException $e){
            return ["error"=>$e->getMessage()];
        }
        $productImages[] = $image;
        
    }


    $productCards =[];
    for ( $i = 0; $i < count($products); $i++){
        $productCards[] = new ProductCard($products[$i],$firstVariants[$i],$productImages[$i], []);
        if (empty($productCards[$i])){
            return ['error' => "error while creating product card , product & productImages number in list :$i" ];
        }
    }
    return ['homeProductCards' => $productCards];
}


function Search(array $params):array{
    global $db;
    if(!isset($params['input'])){
        return ['error'=>'input param not set'];
    }

    if($params['input'] === ""){
        return ['error'=> "input can't be empty"];
    }

    try{
        $productIds = Product::GetProductIdByName($db,$params['input']);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    $products =[];
    foreach($productIds as $productId){
        $products[]= Product::GetProductById($db, $productId);
    }
    $productCards=[];
    try{
        $productCards =  CreateProductCardsWithProductList($products);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }
    
    return ['productCards' =>$productCards];
}

function GetAttributesById(array $params):array{
    global $db;
    if(!isset($params['ids'])){
        return ['error' => 'need ids param'];
    }
    if(!is_array($params['ids'])){
        return['error' => 'ids must be array of number'];
    }

    $attributes= [];

    try{
        $attributes = FilterAttribute::GetAttributesByIds($db,$params['ids']);
    }catch( ErrorException $e ){
        return ['error' => $e->getMessage()];
    }

    return ['attributes' => $attributes];

}

function GetProductsByCategoryPaginated(array $params):array{
    global $db;
    if(!isset($params['category_id'], $params['page'], $params['limit'])){
        return ['error' => 'Missing parameters need : category_id, page & limit'];
    }

    $categoryId = (int) $params['category_id'];
    $page = max(1,(int)$params['page']);
    $limit = max(1,(int)$params['limit']);
    $offset = ($page-1) * $limit;
    try{
        $products = Product::GetProductsByCategoryIdPaginated($db,$categoryId, $limit, $offset);
        $totalCount = Product::CountProductsByCategoryId($db, $categoryId);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    try{
        $productCards = CreateProductCardsWithProductList($products);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    return[
        'productCards'=>$productCards,
        'totalCount'=>$totalCount,
        'currentPage'=>$page,
        'limit' =>$limit,
        'totalPages' => ceil($totalCount/$limit)
    ];
}

function GetProductsByCategoryPaginatedWithFilters(array $params):array{
    global $db;
    if(!isset($params['category_id'], $params['page'], $params['limit'])){
        return ['error' => 'Missing parameters need : category_id, page & limit'];
    }

    if(!isset($params['filters']) && !isset($params['sortOption'])){
        return ['error' => 'missing parameter filter or sortOption'];
    }


    $categoryId = (int) $params['category_id'];
    $page = max(1,(int)$params['page']);
    $limit = max(1,(int)$params['limit']);
    $offset = ($page-1) * $limit;
    $products = [];
    $totalCount = 0;
    
    if(isset($params['sortOption']) && isset($params['filters'])){
        try{
            $sortOption = $params['sortOption'];
           
            $validSortOptions = ['priceAsc', 'priceDesc', 'dateAsc', 'dateDesc'];
            if (!in_array($sortOption, $validSortOptions, true)) {
                return ['error' => 'invalid sort option', $sortOption];
            }
            
            $filters = $params['filters'];
            //products by category with filters & sort 
            $products = Product::GetProductsByCategoryIdPaginatedWithFiltersAndSort($db, $categoryId, $sortOption, $filters, $limit, $offset);
            //total count of this
            $totalCount = Product::CountProductsByCategoryIdWithFilters($db, $categoryId, $filters);
        }catch(ErrorException $e){
            return['error'=>$e->getMessage()];
        }
    }elseif(isset($params['sortOption'])){
        try{
            $sortOption = $params['sortOption'];

            $validSortOptions = ['priceAsc', 'priceDesc', 'dateAsc', 'dateDesc'];
            if (!in_array($sortOption, $validSortOptions, true)) {
                return ['error' => 'invalid sort option', $sortOption];
            }

            //products by category with sort
            $products = Product::GetProductsByCategoryIdPaginatedWithSort($db, $categoryId, $sortOption, $limit, $offset);
            //totalcount of this
            $totalCount = Product::CountProductsByCategoryId($db, $categoryId);
        }catch(ErrorException $e){
            return ['error'=>$e->getMessage()];
        }
    }elseif(isset($params['filters'])){
        try{
            $filters = $params['filters'];
            // products by category with filters
            $products = Product::GetProductsByCategoryIdPaginatedWithFilters($db, $categoryId, $filters, $limit, $offset);
            //total count of this
            $totalCount = Product::CountProductsByCategoryIdWithFilters($db, $categoryId, $filters);
        }catch(ErrorException $e){
            return ['error'=>$e->getMessage()];
        }
    }else{
        return ['error' => 'not isset filter or options unexcpected'];
    }

    $productCards = [];
    try{
        $productCards = CreateProductCardsWithProductList($products);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    return[
        'productCards'=>$productCards,
        'totalCount'=>$totalCount,
        'currentPage'=>$page,
        'limit' =>$limit,
        'totalPages' => ceil($totalCount/$limit)
    ];
}

function SearchPaginatedWithFilters(array $params):array{
    global $db;
    if(!isset($params['input']) || $params['input'] === ""){
        return ['error' => 'missing parameter input'];
    }
    if(!isset($params['limit'], $params['page'])){
        return ['error' => 'missing parameter limit or page or both'];
    }
    if ((!isset($params['filters']) || !is_array($params['filters'])) && (!isset($params['sortOption']))) {
        return ['error' => 'filters must be an array of Filter'];
    }
    

    $input = $params['input'];
    $page = max(1,(int)$params['page']);
    $limit = max(1,(int)$params['limit']);
    $offset = ($page-1) * $limit;
    $totalCount = 0;
    $products = [];

    if(isset($params['filters']) && isset($params['sortOption'])){
        try{
            $sortOption = $params['sortOption'];

            $validSortOptions = ['priceAsc', 'priceDesc', 'dateAsc', 'dateDesc'];
            if (!in_array($sortOption, $validSortOptions, true)) {
                return ['error' => 'invalid sort option', $sortOption];
            }

            $filters = $params['filters'];
            $products = Product::GetProductsBySearchPaginatedWithFiltersAndSort($db, $input, $filters, $sortOption, $limit, $offset);
            $totalCount = Product::CountProductByNameWithFilters($db, $input, $filters);
        }catch(ErrorException $e){
            return ['error'=>$e->getMessage()];
        }
    }elseif(isset($params['sortOption'])){
        try{
            $sortOption = $params['sortOption'];
            $validSortOptions = ['priceAsc', 'priceDesc', 'dateAsc', 'dateDesc'];
            if (!in_array($sortOption, $validSortOptions, true)) {
                return ['error' => 'invalid sort option', $sortOption];
            }
            $products = Product::GetProductsBySearchPaginatedWithSort($db,$input,$sortOption,$limit,$offset);
            $totalCount = Product::CountProductByName($db,$input);
        }catch(ErrorException $e){
            return ['error'=>$e->getMessage()];
        }
    }elseif(isset($params['filters'])){
        try{
            $filters = $params['filters'];
            $products = Product::GetProductBySearchPaginatedWithFilters($db,$input,$filters, $limit,$offset);
            $totalCount = Product::CountProductByNameWithFilters($db,$input, $filters);
        }catch(ErrorException $e){
            return ['error' => $e->getMessage()];
        }
    }else{
        return ['error' => 'not isset filter or options unexcpected'];
    }

    

    try{
        $productCards = CreateProductCardsWithProductList($products);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    return[
        'productCards'=>$productCards,
        'totalCount'=>$totalCount,
        'currentPage'=>$page,
        'limit' =>$limit,
        'totalPages' => ceil($totalCount/$limit)
    ];
}

function GetProductsBySubcategoryPaginatedWithFilters(array $params):array{
    global $db;
    if(!isset($params['subcategory_id'], $params['page'], $params['limit'])){
        return ['error' => 'Missing parameters need : subcategory_id, page & limit'];
    }

    if(!isset($params['filters']) && !isset($params['sortOption'])){
        return ['error' => 'missing parameter filter or sortOption'];
    }


    $subcategoryId = (int) $params['subcategory_id'];
    $page = max(1,(int)$params['page']);
    $limit = max(1,(int)$params['limit']);
    $offset = ($page-1) * $limit;
    $products = [];
    $totalCount = 0;
    
    if(isset($params['sortOption']) && isset($params['filters'])){
        try{
            $sortOption = $params['sortOption'];
           
            $validSortOptions = ['priceAsc', 'priceDesc', 'dateAsc', 'dateDesc'];
            if (!in_array($sortOption, $validSortOptions, true)) {
                return ['error' => 'invalid sort option', $sortOption];
            }
            
            $filters = $params['filters'];
            //products by category with filters & sort 
            $products = Product::GetProductsBySubcategoryIdPaginatedWithFiltersAndSort($db, $subcategoryId, $sortOption, $filters, $limit, $offset);
            //total count of this
            $totalCount = Product::CountProductsBySubCategoryIdWithFilters($db, $subcategoryId, $filters);
        }catch(ErrorException $e){
            return['error'=>$e->getMessage()];
        }
    }elseif(isset($params['sortOption'])){
        try{
            $sortOption = $params['sortOption'];
            
            $validSortOptions = ['priceAsc', 'priceDesc', 'dateAsc', 'dateDesc'];
            if (!in_array($sortOption, $validSortOptions, true)) {
                return ['error' => 'invalid sort option', $sortOption];
            }

            //products by category with sort
            $products = Product::GetProductsBysubcategoryIdPaginatedWithSort($db, $subcategoryId, $sortOption, $limit, $offset);
            //totalcount of this
            $totalCount = Product::CountProductsBysubcategoryId($db, $subcategoryId);
        }catch(ErrorException $e){
            return ['error'=>$e->getMessage()];
        }
    }elseif(isset($params['filters'])){
        try{
            $filters = $params['filters'];
            // products by category with filters
            $products = Product::GetProductsByCategoryIdPaginatedWithFilters($db, $subcategoryId, $filters, $limit, $offset);
            //total count of this
            $totalCount = Product::CountProductsBySubcategoryIdWithFilters($db, $subcategoryId, $filters);
        }catch(ErrorException $e){
            return ['error'=>$e->getMessage()];
        }
    }else{
        return ['error' => 'not isset filter or options unexcpected'];
    }

    $productCards = [];
    try{
        $productCards = CreateProductCardsWithProductList($products);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    return[
        'productCards'=>$productCards,
        'totalCount'=>$totalCount,
        'currentPage'=>$page,
        'limit' =>$limit,
        'totalPages' => ceil($totalCount/$limit)
    ];
}

function GetProductsBySubcategoryPaginated(array $params):array{
    global $db;
    if(!isset($params['subcategory_id'], $params['page'], $params['limit'])){
        return ['error' => 'Missing parameters need : subcategory_id, page & limit'];
    }

    $subcategory_id = (int) $params['subcategory_id'];
    $page = max(1,(int)$params['page']);
    $limit = max(1,(int)$params['limit']);
    $offset = ($page-1) * $limit;
    try{
        $products = Product::GetProductsBySubcategoryIdPaginated($db,$subcategory_id, $limit, $offset);
        $totalCount = Product::CountProductsBySubcategoryId($db, $subcategory_id);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    try{
        $productCards = CreateProductCardsWithProductList($products);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    return[
        'productCards'=>$productCards,
        'totalCount'=>$totalCount,
        'currentPage'=>$page,
        'limit' =>$limit,
        'totalPages' => ceil($totalCount/$limit)
    ];
}

function SearchPaginated(array $params):array{
    global $db;
    if(!isset($params['input']) || $params['input'] === ""){
        return ['error' => 'missing parameter input'];
    }
    if(!isset($params['limit'], $params['page'])){
        return ['error' => 'missing parameter limit or page or both'];
    }
    $input = $params['input'];
    $page = max(1,(int)$params['page']);
    $limit = max(1,(int)$params['limit']);
    $offset = ($page-1) * $limit;

    try{
        $products = Product::GetProductsBySearchPaginated($db,$input,$limit,$offset);
        $totalCount = Product::CountProductByName($db,$input);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    try{
        $productCards = CreateProductCardsWithProductList($products);
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    return[
        'productCards'=>$productCards,
        'totalCount'=>$totalCount,
        'currentPage'=>$page,
        'limit' =>$limit,
        'totalPages' => ceil($totalCount/$limit)
    ];
}


function GetAttrVAttrByCategory(array $params):array{
    global $db;
    if(!isset($params['category_id'])){
        return ['error'=> 'missing param category_id'];
    }
    
    $attrVAttr = [];

    try{
        $categoryId = (int)$params['category_id'];
        $attributes = FilterAttribute::GetAttributesByCategory($db,$categoryId);
        foreach($attributes as $attribute){
            $variantAttributes = VariantAttribute::GetVariantAttributesByCategoryAndAttributeId($db,$categoryId,$attribute->GetId());
            $attrVAttr[] = new AttrvAttr($attribute,$variantAttributes);
        }


    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }


    
    return['attrVAttr' => $attrVAttr];
}

function GetAttrVAttrBySubcategory(array $params):array{
    global $db;
    if(!isset($params['subcategory_id'])){
        return ['error'=> 'missing param category_id'];
    }
    $attrVAttr = [];

    try{
        $subcategory_id = (int)$params['subcategory_id'];
        $attributes = FilterAttribute::GetAttributesBySubcategory($db, $subcategory_id);
        foreach($attributes as $attribute){
            $variantAttributes = VariantAttribute::GetVariantAttributesBySubCategoryAndAttributeId($db,$subcategory_id, $attribute->GetId());
            $attrVAttr[]= new AttrvAttr($attribute, $variantAttributes);
        }
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    return ['attrVAttr' => $attrVAttr];
}

function GetAttrVAttrBySearch(array $params): array{
    global $db;
    if(!isset($params['input'])){
        return ['error' => 'missing param input'];
    }
    $attrVAttr = [];

    try{
        $input = $params['input'];
        $attributes = FilterAttribute::GetAttributesBySearch($db, $input);
        foreach($attributes as $attribute){
            $variantAttributes =VariantAttribute::GetVariantAttributesBySearchAndAttributeId($db,$input,$attribute->GetId());
            $attrVAttr[]=new AttrvAttr($attribute,$variantAttributes);
        }
    }catch(ErrorException $e){
        return ['error' => $e->getMessage()];
    }

    return ['attrVAttr' => $attrVAttr];
}

