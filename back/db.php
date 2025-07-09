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
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], $row['price'], $row['stock'],$createdAt);
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
        foreach($results as $row){
            $createdAt = new DateTime($row['created_at']);
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], $row['price'], $row['stock'],$createdAt);
        }

        return $products;
    }

    public function GetProductFirstImage(int $product_id): ProductImage{
        $query = "SELECT * FROM product_image WHERE product_id = :product_id AND position = :position ";
        $params =[
            ':product_id' => $product_id,
            ':position' => 1
        ];
        

        $results = $this->executeQuery($query, $params);

        $row = $results[0];
        
        $createdAt = new DateTime($row['created_at']);
        $productFirstImage = new ProductImage($row['id'], $row['product_id'], $row['image_name'], $row['alt_text'], $row['position'],$createdAt);
        return $productFirstImage;
    }
    

}


