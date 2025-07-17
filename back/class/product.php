<?php 


class Product{
    private int $id;
    private int $subcatecory_id;
    private string $name;
    private string $description;
    
    private DateTime $created_at;

    public function __construct(int $id, int $subcatecory_id, 
    string $name, string $description, DateTime $created_at){
        $this->id = $id;
        $this->subcatecory_id = $subcatecory_id;
        $this->name = $name;
        $this->description = $description;
        $this->created_at = $created_at;
    }

    public function GetId():int{
        return $this->id;
    }


    public function GetName():string{
        return $this->name;
    }

    

    public function GetDescription():string{
        return $this->description;
    }

    public function GetCreatedAt(): string{
        return $this->created_at->format(DateTime::ATOM);
    }

    /**
     * Summary of getProductBySubCategory
     * @param int $subcatecory_id
     * @return Product[]
     */
    public static  function getProductsBySubCategoryId(Database $db,int $subcatecory_id): array{
        $query = "SELECT * FROM product WHERE subcategory_id = :subcategory_id";
        $params =[
            ':subcategory_id' =>$subcatecory_id
        ];
        $results = $db->executeQuery($query,$params);
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
    public static function getProductsByCategoryId(Database $db,int $category_id): array{
        $products =[];
        $query = "SELECT p.* FROM product p JOIN subcategory s ON p.subcategory_id = s.id WHERE s.category_id = :category_id ";
        $params = [
            ':category_id' => $category_id
        ];

        $results = $db->executeQuery($query, $params);
        if(count($results) >0){
            foreach($results as $row){
                $createdAt = new DateTime($row['created_at']);
                $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], $createdAt);
            }

            return $products;
        }
        throw new ErrorException("No products found for category : $category_id");
        
    }


    public static function GetProductById(Database $db,int $id):Product{
        $query = "SELECT * FROM product WHERE id = :id";
        $params = [
            ':id' => $id
        ];

        $results = $db->executeQuery($query,$params);
        $row = $results[0];

        $createdAt = new DateTime($row['created_at']);
        $product = new Product($row['id'], $row['subcategory_id'], $row['name'],$row['description'],  $createdAt);
        return $product;
    
    }

     /**
     * Summary of Get6RandomProducts
     * @return int[]
     */
    public static function GetRandomProductsIds(Database $db,int $limit):array{
        if($limit <=0){
            throw new ErrorException("limit must be positive");
        }

        $query = "SELECT id FROM product order by RAND() limit $limit";
        
        $results = $db->executeQuery($query);
        if(empty($results)){
            throw new ErrorException("no products found when searching random products");
        }
        $productsIds = [];
        foreach($results as $row){
            $productsIds[] = $row['id'];
        }
        return $productsIds;
    } 


    /**
     * Summary of ResearchProduct
     * @param string $input
     * @return int[]
     */
    public static function GetProductIdByName(Database $db, $input):array{
        $query ="SELECT id from product where name like :input";
        $params= [
            ":input" => "%{$input}%"
        ];
        $results = $db->executeQuery($query, $params);
        if(empty($results)){
            throw new ErrorException("no id found for your research : $input");
        }
        $ids = [];
        foreach($results as $row){
            $ids[] = $row['id'];
        }
        return $ids;
    }

    /**
     * Summary of GetProductsByCategoryIdPaginated
     * @param int $category_id
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsByCategoryIdPaginated(Database $db, int $category_id, int $limit,int $offset):array{
        $query = "SELECT p.* FROM product p JOIN subcategory s ON p.subcategory_id = s.id WHERE s.category_id = :category_id LIMIT $limit OFFSET $offset";

        

        $params = [':category_id' => $category_id];
        
        $results = $db->executeQuery($query, $params);

        $products = [];
        foreach($results as $row){
            $products[] = new Product($row['id'],  $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }

        return $products;
    
    }
    /**
     * Summary of GetProductsBySubcategoryIdPaginated
     * @param Database $db
     * @param int $subcategory_id
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsBySubcategoryIdPaginated(Database $db, int $subcategory_id, int $limit, int $offset):array{
        $query = "SELECT * FROM product where subcategory_id = :subcategory_id limit :limit offset :offset";
        $params =[
            ':subcategory_id' => $subcategory_id,
            ':limit' => $limit,
            ':offset' => $offset
        ];

        $results = $db->executeQuery($query, $params);
        $products=[];
        foreach($results as $row){
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }
        return $products;
    }

    public static function CountProductsByCategoryId(Database $db,int $categoryId):int{
        $query = "SELECT count(*) as count FROM product p join subcategory s on p.subcategory_id = s.id where s.category_id = :category_id";
        $params =[':category_id' => $categoryId];
        $results = $db->executeQuery($query,$params);
        return isset($results[0]['count']) ? (int)$results[0]['count'] : 0;
    }
    
    public static function CountProductsBySubcategoryId(Database $db, int $subcategoryId):int{
        $query = "SELECT count(*) as count from product where subcategory_id = :subcategory_id";
        $params = [':subcategory_id' =>$subcategoryId];
        $results = $db->executeQuery($query,$params);
        return isset($results[0]['count']) ? (int)$results[0]['count'] : 0;
    }


    
}