<?php

require_once(__DIR__ . '/db.php');
$db = new Database('localhost', '3307', 'ecommerce_template_1','root', '');


function GetData(array $params):array{
    global $db;
    if (empty($params['action'])) {
        return ['error' => 'action must contain a valid action'];
    }

    $params['action'] = strtolower($params['action']);

    switch ($params['action']){
        case 'getcategories':
            $categories = Category::getCategories($db);
            if(empty($categories)){
                return ['error'=>'no categories found'];
            }
            return ['categories' => $categories];
        
        case 'getsubcategories':
            
            if (!isset($params['categoryid']) || !is_int($params['categoryid']) || $params['categoryid'] <= 0) {
                return ['error' => 'categoryid is empry or invalid'];
            }

            $subcategories = SubCategory::getSubCategories($db,$params['categoryid']);
            if(empty($subcategories)){
                return ['error' => 'no subcategories found'];
            }

            return ['subcategories' => $subcategories];
        case 'getproductcard':
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
        
        case 'getproductdetail':
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
        
        case 'gethomecategories':
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
        
        case 'gethomeproducts':
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
        
        case 'search':
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
                
        case 'getattributesbyid':
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