<?php
require_once(__DIR__ . '/db.php');
$db = new Database('localhost', '3307', 'ecommerce_template_1','root', '');

$classes = glob(__DIR__ . '/class/*.php');

foreach ($classes as $file) {
    require_once $file;
}




function GetData(array $params):array{
    global $db;
    if (empty($params['action'])) {
        return ['error' => 'action must contain a valid action'];
    }

    $params['action'] = strtolower($params['action']);

    switch ($params['action']){
        case 'getcategories':
            $categories = $db->getCategories();
            return ['categories' => $categories];
        
        case 'getsubcategories':
            
            if (!isset($params['categoryid']) || !is_int($params['categoryid']) || $params['categoryid'] <= 0) {
                return ['error' => 'categoryid is empry or invalid'];
            }
            $subcategories = $db->getSubCategories($params['categoryid']);
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

                $products = $db->getProductsByCategoryId($params['id']);

                $productImages= [];
                foreach($products as $product){
                    $productImages[] = $db->GetProductFirstImage($product->GetId());
                }

                $productCards =[];
                for ( $i = 0; $i < count($products); $i++){
                    $productCards[] = new ProductCard($products[$i],$productImages[$i], []);
                }

                return ['productCards' => $productCards];
            }
            if ($params['param'] === 'subcategory'){

                $products = $db->getProductsBySubCategoryId($params['id']);
                
                $productImages = [];
                foreach($products as $product){
                    $productImages[]= $db->GetProductFirstImage($product->GetId());                 
                }

                $productCards = [];
                for($i = 0; $i < count($products); $i++){
                    $productCards[] = new ProductCard($products[$i],$productImages[$i], []);
                }

                return ['productCards' => $productCards];
            }

            return ['error' => 'invalid param'];


        default:
            return ['error' => 'Unknown action'];
    }

}