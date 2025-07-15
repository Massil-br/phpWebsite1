<?php
$classes = glob(__DIR__ . '/class/*.php');


foreach ($classes as $file) {
    require_once $file;
}

class Database {
    private PDO $pdo;

    public function __construct(string $host, string $port, string $db, string $user, string $pass, string $charset = 'utf8mb4') {
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

   
    private function executeQuery(string $query, array $params = []): array|bool {
        try {
            $stmt = $this->pdo->prepare($query);

            foreach ($params as $key => &$value) {
                $stmt->bindParam($key, $value);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /** @return Category[] */
    public function getCategories():array{
        $query = "SELECT * FROM category";
        $results = $this->executeQuery($query);
        $categories = [];
        foreach($results as $row){
            $createdAt = new DateTime($row['created_at']);
            $categories[] = new Category($row['id'], $row['name'],$row['description'], $createdAt);
        }

        return $categories;
    }
    /** @return SubCategory[] */
    public function getSubCategories(int $category_id): array{
        $query = "SELECT * FROM subcategory WHERE category_id = :category_id";
        $params = [
            ':category_id' => $category_id
        ];
        $results = $this->executeQuery($query,$params);

        $subcategories = [];
        foreach($results as $row){
            $createdAt = new DateTime($row['created_at']);
            $subcategories[]= new SubCategory($row['id'], $row['category_id'], $row['name'], $row['description'],$createdAt);
        }
        return $subcategories;
    }

    /**
     * Summary of getProductBySubCategory
     * @param int $subcatecory_id
     * @return Product[]
     */
    public function getProductsBySubCategoryId(int $subcatecory_id): array{
        $query = "SELECT * FROM product WHERE subcategory_id = :subcategory_id";
        $params =[
            ':subcategory_id' =>$subcatecory_id
        ];
        $results = $this->executeQuery($query,$params);
        $products = [];
        foreach($results as $row){
            $createdAt = new DateTime($row['created_at']);
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], $createdAt);
        }
        return $products;
    }
    /** 
     * @return Product[]
    */
    public function getProductsByCategoryId(int $category_id): array{
        $products =[];
        $query = "SELECT p.* FROM product p JOIN subcategory s ON p.subcategory_id = s.id WHERE s.category_id = :category_id ";
        $params = [
            ':category_id' => $category_id
        ];

        $results = $this->executeQuery($query, $params);
        if(count($results) >0){
            foreach($results as $row){
                $createdAt = new DateTime($row['created_at']);
                $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], $createdAt);
            }

            return $products;
        }
        throw new ErrorException("No products found for category : $category_id");
        
    }

    public function GetProductFirstImage(int $product_id): VariantImage{
        $id = 0;
        try{
            $variant = $this->GetFirstVariantByProductId($product_id);
            $id = $variant->GetId();
        }catch(ErrorException $e){
            throw new ErrorException("first variant by produc id : $product_id , not found");
        }
        $query = "SELECT * FROM variant_image WHERE variant_id = :variant_id AND position = :position ";
        $params =[
            ':variant_id' => $id,
            ':position' => 1
        ];
        

        $results = $this->executeQuery($query, $params);
        if(isset($results[0])){
            $row = $results[0];
        
            
            $variantFirstImage = new VariantImage($row['id'], $row['variant_id'], $row['image_name'], $row['alt_text'], $row['position']);
            return $variantFirstImage;
        }
        throw new ErrorException("no images found in database");
       
    }

    public function GetProductById(int $id):Product{
        $query = "SELECT * FROM product WHERE id = :id";
        $params = [
            ':id' => $id
        ];

        $results = $this->executeQuery($query,$params);
        $row = $results[0];

        $createdAt = new DateTime($row['created_at']);
        $product = new Product($row['id'], $row['subcategory_id'], $row['name'],$row['description'],  $createdAt);
        return $product;
    
    }
    /**
     * Summary of GetProductImages
     * @param int $id
     * @return VariantImage[]
     */
    public function GetProductImages(int $product_id): array{
        try{
            $ids = $this->GetProductVariantsIdsByProductId($product_id);
             
        }catch(ErrorException $e){
            throw new ErrorException($e->getMessage());
        }

        $productimages = [];

        foreach($ids as $id){
            $query = "SELECT * FROM variant_image WHERE variant_id = :id";
            $params = [
                ':id' => $id
            ];

            $results = $this->executeQuery($query, $params);

        
            foreach($results as $row){
                $productimages[] = new VariantImage($row['id'],$row['variant_id'], $row['image_name'], $row['alt_text'], $row['position'] );
            }
        }
        
        return $productimages;

    }

    /**
     * Summary of GetProductAttributes
     * @param int $id
     * @return VariantAttribute[]
     */
    public function GetProductAttributes(int $id):array{
        $query = "SELECT * FROM variant_attribute WHERE variant_id = :id";
        $params =[
            ':id'=> $id
        ];

        $results = $this->executeQuery($query, $params);

        $productAttributes = [];
        foreach($results as $row){
            $productAttributes[] = new VariantAttribute($row['variant_id'],$row['attribute_id'], $row['value']);
        }
        return $productAttributes;

    }

    /**
     * Summary of GetAttribute
     * @param int[] $ids
     * @return FilterAttribute[]
     */
    public function GetAttributes(array $ids): array{
        $query = "SELECT * FROM attribute WHERE id = :id";
        $idMarked = [];
        foreach($ids as $id){
            if(!in_array($id,$idMarked)){
                $idMarked[] = $id;
            }
        }

        $attributes = [];
        foreach($idMarked as $id){
            $params = [
                ':id' => $id
            ];

            $results = $this->executeQuery($query, $params);
            $row = $results[0];

            $attributes[]= new FilterAttribute($row['id'], $row['name']);

        }

        return $attributes;
        
    }

    public function GetFirstVariantByProductId(int $id):ProductVariant{
        $query = "SELECT * FROM variant WHERE product_id = :id";
        $params =[
            ':id' =>$id
        ];

        $results = $this->executeQuery($query, $params);
        if(isset($results[0])){
            $row = $results[0];
            $variant = new ProductVariant($row['id'], $row['product_id'], $row['sku'], $row['price'], $row['stock'], $row['created_at']);
            return $variant;
        }
        throw new ErrorException("no variant found for this product, product_id : $id");
        
    }

    /**
     * Summary of GetProductVariantsByProductId
     * @param int $id
     * @return ProductVariant[]
     */
    public function GetProductVariantsByProductId(int $id):array{
        $query = "SELECT * FROM variant WHERE product_id =:id";
        $params =[
            ':id' => $id
        ];

        $results = $this->executeQuery($query, $params);
        $variants = [];
        foreach($results as $row){
            $variants[] = new ProductVariant($row['id'], $row['product_id'], $row['sku'], $row['price'], $row['stock'], $row['created_at']);
        }
        return $variants;
    }
    /**
     * Summary of GetProductVariantsIdsByProductId
     * @param int $id
     * @throws \ErrorException
     * @return int[]
     */
    public function GetProductVariantsIdsByProductId(int $id):array{
        $query = "SELECT id FROM variant WHERE product_id =:id";
        $params = [
            ':id' =>$id
        ];

        $results = $this->executeQuery($query, $params);
        if (count($results) >0){
            $ids = [];
            foreach($results as $row){
                $ids[] = $row['id'];
            }
            return $ids;
        }
        throw new ErrorException("no variants found for product : $id");
        
    }
    /**
     * Summary of Get3RandomCategories
     * @return Category[]
     */
    public function Get3RandomCategories():array{
        $query ="SELECT * FROM category ORDER BY RAND() LIMIT 3";
        $results = $this->executeQuery($query);
        if(isset($results)){
            $categories =[];
            foreach($results as $row){
                $createdAt = new DateTime($row['created_at']);
                $categories[] = new Category($row['id'], $row['name'], $row['description'], $createdAt);
            }
            return $categories;
        }
        throw new ErrorException("error while trying to get 3 rand categories");
    }

    public function GetRandImageByCategoryId($category_id): VariantImage{
        $query ="SELECT id from subcategory WHERE category_id =:id ORDER BY RAND() LIMIT 1";
        $params =[
            ":id" => $category_id
        ];
        $results = $this->executeQuery($query, $params);
        if(empty($results)){
           throw new ErrorException("no subcategory found for category id : $category_id"); 
        }
        $subcategoryId = $results[0]['id'];

        $query ="SELECT id from product WHERE subcategory_id = :subcategory_id order by RAND() LIMIT 1 ";
        $params=[
            ":subcategory_id" => $subcategoryId
        ];
        $results = $this->executeQuery($query,$params);
        if(empty($results)){
           throw new ErrorException("no product found for subcategory id : $subcategoryId"); 
        }
        $productId = $results[0]['id'];

        $query = "SELECT id from variant where product_id = :product_id order by RAND() LIMIT 1";
        $params =[
            "product_id" => $productId
        ];
        $results = $this->executeQuery($query,$params);
        if(empty($results)){
           throw new ErrorException("no variant found for product id : $productId"); 
        }
        $variantId = $results[0]['id'];


        $query = "SELECT * from variant_image where variant_id =:variant_id and position = 1";
        $params = [
            "variant_id" =>$variantId
        ];
        $results = $this->executeQuery($query, $params);
        if(empty($results)){
           throw new ErrorException("no variant_image found for variant id : $variantId"); 
        }
        $row = $results[0];
        $variantImage = new VariantImage($row['id'],$row['variant_id'], $row['image_name'], $row['alt_text'], $row['position']);
        return $variantImage;
    }
    /**
     * Summary of Get6RandomProducts
     * @return int[]
     */
    public function GetRandomProductsIds(int $limit):array{
        if($limit <=0){
            throw new ErrorException("limit must be positive");
        }

        $query = "SELECT id FROM product order by RAND() limit $limit";
        
        $results = $this->executeQuery($query);
        if(empty($results)){
            throw new ErrorException("no products found when searching random products");
        }
        $productsIds = [];
        foreach($results as $row){
            $productsIds[] = $row['id'];
        }
        return $productsIds;
    } 

    // public function CreateCategory(string $name, string $description){
    //     $query = "INSERT INTO category (name, description) values(:name, :description)";
    //     $params=[
    //         ":name" =>$name,
    //         ":description" => $description
    //     ];
    //     $this->executeQuery($query,$params);
    // }

    // public function CreateSubCategory(int $category_id, string $name, string $description){
    //     $query = "INSERT into subcategory (category_id, name, description) values(:category_id, :name, :description)";
    //     $params = [
    //         ":category_id" =>$category_id,
    //         ":name" => $name,
    //         ":description" => $description
    //     ];
    //     $this->executeQuery($query, $params);
    // }

    // public function CreateProduct(int $subcategory_id, string $name, string $description){
    //     $query = "INSERT into product (subcategory_id, name, description) values (:subcategory_id, :name, :description) ";
    //     $params = [
    //         ":subcategory_id" => $subcategory_id,
    //         ":name"=>$name,
    //         ":description" => $description
    //     ];
    // }


    // public function CreateVariant(int $product_id, string $sku, float $price, int $stock){
    //     $query = "INSERT into variant (product_id, sku, price, stock) values (:product_id, :sku, :price, :stock)";
    //     $params = [
    //         ":product_id" => $product_id,
    //         ":sku" => $sku,
    //         ":price"=>$price,
    //         ":stock" => $stock
    //     ];

    //     $this->executeQuery($query, $params);
    // }

    // public function CreateAttribute(string $name){
    //     $query ="INSERT into attribute (name) values (:name)";
    //     $params =[
    //         ":name" => $name
    //     ];
    //     $this->executeQuery($name);
    // }

    // public function CreateVariantAttribute(int $variant_id, int $attribute_id, string $value){
    //     $query ="INSERT into variant_attribute (variant_id, attribute_id, value) values (:variant_id, :attribute_id, :value)";
    //     $params =[
    //         ":variant_id" => $variant_id,
    //         ":attribute_id" =>$attribute_id,
    //         ":value" =>$value
    //     ];

    //     $this->executeQuery($query, $params);
    // }

    // public function CreateVariantImage(int $variant_id, string $image_name, string $alt_text, int $position ){
    //     $query = "INSERT into variant_image (variant_id, image_name, alt_text, position) values (:variant_id, :image_name, :alt_text, :position)";
    //     $params = [
    //         ":variant_id" => $variant_id,
    //         ":image_name" => $image_name,
    //         ":alt_text"=>$alt_text,
    //         ":position" => $position
    //     ];
    //     $this->executeQuery($query, $params);
    // }


}


