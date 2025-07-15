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
            $categories = $db->getCategories();
            if(empty($categories)){
                return ['error'=>'no categories found'];
            }
            return ['categories' => $categories];
        
        case 'getsubcategories':
            
            if (!isset($params['categoryid']) || !is_int($params['categoryid']) || $params['categoryid'] <= 0) {
                return ['error' => 'categoryid is empry or invalid'];
            }

            $subcategories = $db->getSubCategories($params['categoryid']);
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
                    $products = $db->getProductsByCategoryId($params['id']);
                    
                }catch(ErrorException $e){
                    return ["error" => $e->getMessage()];
                }
                

                $firstVariants = [];
                $productImages= [];
                foreach($products as $product){
                    try{
                        $variant = $db->GetFirstVariantByProductId($product->GetId());
                    }catch(ErrorException $e){
                        return ["error" => $e->getMessage(), "products" => $products];
                    }
                    $firstVariants[]= $variant;
                    try{
                        $image = $db->GetProductFirstImage($product->GetId());
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

                return ['productCards' => $productCards];
            }
            if ($params['param'] === 'subcategory'){

                $products = $db->getProductsBySubCategoryId($params['id']);
                if (empty($products)){
                    return ['error'=> 'product not found'];

                }

                $firstVariants = [];
                $productImages = [];
                foreach($products as $product){
                    $image = $db->GetProductFirstImage($product->GetId());
                    if(empty($image)){
                        $id = $product->GetId();
                        return ['error' => " image not found,  product id : $id"];
                    }
                    $productImages[] = $image;

                    $variant = $db->GetFirstVariantByProductId($product->GetId());
                    if(empty($variant)){
                        $id = $product->GetId();
                        return ['error' => "variant not found , product id : $id"];
                    }
                    $firstVariants[]= $variant;
                }

                $productCards = [];
                for($i = 0; $i < count($products); $i++){
                    $productCards[] = new ProductCard($products[$i],$firstVariants[$i],$productImages[$i], []);
                    if (empty($productCards[$i])){
                        return ['error' => "error while creating product card , product & productImages number in list :$i" ];
                    }
                }

                return ['productCards' => $productCards];
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

            $product = $db->getProductById($params['id']);
            if(empty($product)){
                return ['error' => 'product not found'];
            }

            $variants= $db->GetProductVariantsByProductId($product->GetId());
            if(empty($variants)){
                return ['error'=>['no variants found']];
            }
            

            $productImages = $db->GetProductImages($params['id']);
            if(empty($productImages)){
                return ['error' => 'no productImages found'];
            }
            $productAttributes = [];
            foreach($variants as $variant){
                $productAttributes   = $db->GetProductAttributes($variant->GetId());
                if(empty($productAttributes)){
                    return ['error'=> 'no product attributes found'];
                }
            }
            

            $ids = [];
            foreach($productAttributes as $p){
                $ids[]= $p->GetAttributeId();
            }

            $attributes =$db->GetAttributes($ids);
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
               $categories =  $db->Get3RandomCategories();
               foreach($categories as $category){
                    $variantImage = $db->GetRandImageByCategoryId($category->GetId());
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

            $productIds = $db->GetRandomProductsIds($params['limit']);
            $products =[];

            foreach($productIds as $productId){
                $products[]= $db->GetProductById($productId);
            }

            $firstVariants = [];
            $productImages= [];
            foreach($products as $product){
                try{
                    $variant = $db->GetFirstVariantByProductId($product->GetId());
                }catch(ErrorException $e){
                    return ["error" => $e->getMessage(), "products" => $products];
                }
                $firstVariants[]= $variant;
                try{
                    $image = $db->GetProductFirstImage($product->GetId());
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
                $productIds = $db->GetProductIdByName($params['input']);
            }catch(ErrorException $e){
                return ['error' => $e->getMessage()];
            }

            $products =[];
            foreach($productIds as $productId){
                $products[]= $db->GetProductById($productId);
            }

             $firstVariants = [];
            $productImages= [];
            foreach($products as $product){
                try{
                    $variant = $db->GetFirstVariantByProductId($product->GetId());
                }catch(ErrorException $e){
                    return ["error" => $e->getMessage(), "products" => $products];
                }
                $firstVariants[]= $variant;
                try{
                    $image = $db->GetProductFirstImage($product->GetId());
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
            return ['productCards' =>$productCards];
                


        default:
            return ['error' => 'Unknown action'];
    }

}