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

   
    public function executeQuery(string $query, array $params = []): array|bool {
    try {
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $key => $value) {
            if (is_int($key)) {
                $stmt->bindValue($key + 1, $value);
            } else {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
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


$db = new Database('localhost', '3307', 'ecommerce_template_1','root', '');


