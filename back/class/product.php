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
     * Summary of GetProductsByCategoryIdPaginated
     * @param int $category_id
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsByCategoryIdPaginatedWithSort(Database $db, int $category_id, string $sortOption, int $limit,int $offset):array{
        $query = "SELECT p.* FROM product p 
        JOIN subcategory s ON p.subcategory_id = s.id
        JOIN variant v ON v.product_id = p.id
        WHERE s.category_id = :category_id";
        switch($sortOption){
        case 'priceAsc':
            $query .= " ORDER BY v.price ASC";
            break;
        case 'priceDesc':
            $query .=" ORDER BY v.price Desc";
            break;
        case 'dateAsc':
            $query .=" ORDER BY p.created_at ASC";
            break;
        case 'dateDesc':
            $query .=" ORDER BY p.created_at DESC";
            break;
        default:
            $query .= " Order BY p.created_at DESC";
        }
        $query .=" LIMIT :limit OFFSET :offset";
        $params = [
            ':category_id' => $category_id,
            ':limit' => $limit,
            ':offset' =>$offset
        ];
        

        $results = $db->executeQuery($query, $params);

        $products = [];
        foreach($results as $row){
            $products[] = new Product($row['id'],  $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }

        return $products;
    
    }

    /**
     * Summary of GetProductsByCategoryIdPaginated
     * @param int $category_id
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsBysubcategoryIdPaginatedWithSort(Database $db, int $subcategory_id, string $sortOption, int $limit,int $offset):array{
        $query = "SELECT p.* FROM product p 
        JOIN variant v ON v.product_id = p.id
        WHERE p.subcategory_id = :subcategory_id";
        switch($sortOption){
        case 'priceAsc':
            $query .= " ORDER BY v.price ASC";
            break;
        case 'priceDesc':
            $query .=" ORDER BY v.price Desc";
            break;
        case 'dateAsc':
            $query .=" ORDER BY p.created_at ASC";
            break;
        case 'dateDesc':
            $query .=" ORDER BY p.created_at DESC";
            break;
        default:
            $query .= " Order BY p.created_at DESC";
        }
        $query .=" LIMIT :limit OFFSET :offset";
        $params = [
            ':subcategory_id' => $subcategory_id,
            ':limit' => $limit,
            ':offset' =>$offset
        ];
        

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

    /**
     * Summary of GetProductsBySearchPaginated
     * @param Database $db
     * @param string $input
     * @return Product[]
     */
    public static function GetProductsBySearchPaginated(Database $db, string $input ,int $limit, int $offset): array{
        $query = "SELECT * FROM product WHERE name like :input LIMIT :limit OFFSET :offset";
        $params =[
            ":input" => "%{$input}%",
            ":limit" => $limit,
            ":offset" => $offset
        ];
        $results =$db->executeQuery($query,$params);
        $products = [];
        foreach($results as $row){
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at'])); 
        }
        return $products;
    }

     /**
     * Summary of GetProductsBySearchPaginated
     * @param Database $db
     * @param string $input
     * @param string $sortOption
     * @return Product[]
     */
    public static function GetProductsBySearchPaginatedWithSort(Database $db, string $input,string $sortOption ,int $limit, int $offset): array{
        $query = "SELECT p.* FROM product p JOIN variant v on v.product_id = p.id  WHERE p.name like :input";
        $params =[
            ":input" => "%{$input}%",
            ":limit" => $limit,
            ":offset" => $offset
        ];

        switch($sortOption){
            case 'priceAsc':
                $query .= " ORDER BY v.price ASC";
                break;
            case 'priceDesc':
                $query .=" ORDER BY v.price Desc";
                break;
            case 'dateAsc':
                $query .=" ORDER BY p.created_at ASC";
                break;
            case 'dateDesc':
                $query .=" ORDER BY p.created_at DESC";
                break;
            default:
                $query .= " Order BY p.created_at DESC";
        }
        $query .=" LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;


        $results =$db->executeQuery($query,$params);
        $products = [];
        foreach($results as $row){
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at'])); 
        }
        return $products;
    }

    /**
     * Summary of GetProductBySearchPaginatedWithFilters
     * @param Database $db
     * @param string $input
     * @param Filter[] $filters
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductBySearchPaginatedWithFilters(Database $db, string $input, array $filters, int $limit, int $offset):array{
        $query = "SELECT distinct p.* from product p where p.name like :input";
        $params = ['input' => "%$input%"];
        $i = 0;
        
        foreach($filters as  $filter){
            $name =(string)$filter->name->value;
            $values = $filter->values;
            $placeholders = [];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists (
                SELECT 1 FROM variant v join variant_attribute va 
                on va.variant_id = v.id join attribute a 
                on a.id = va.attribute_id 
                where v.product_id = p.id
                and a.name = :attr_{$name} 
                and va.value IN (".implode(',',$placeholders)."))";
            $params[":attr_{$name}"] = $name;
        }
        $query .=" LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        $results = $db->executeQuery($query, $params);

        $products=[];
        foreach($results as $row){
            $products[]= new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }
        return $products;
        
    }
     /**
     * Summary of GetProductBySearchPaginatedWithFilters
     * @param Database $db
     * @param string $input
     * @param Filter[] $filters
     * @param string $sortOption;
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsBySearchPaginatedWithFiltersAndSort(Database $db, string $input, array $filters, string $sortOption, int $limit, int $offset):array{
        $query = "SELECT distinct p.* from product p JOIN variant v on v.product_id = p.id where p.name like :input";
        $params = ['input' => "%$input%"];
        $i = 0;
        
        foreach($filters as  $filter){
            $name =(string)$filter->name->value;
            $values = $filter->values;
            $placeholders = [];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists (
                SELECT 1 FROM variant v join variant_attribute va 
                on va.variant_id = v.id join attribute a 
                on a.id = va.attribute_id 
                where v.product_id = p.id
                and a.name = :attr_{$name} 
                and va.value IN (".implode(',',$placeholders)."))";
            $params[":attr_{$name}"] = $name;
        }

        switch($sortOption){
            case 'priceAsc':
                $query .= " ORDER BY v.price ASC";
                break;
            case 'priceDesc':
                $query .=" ORDER BY v.price Desc";
                break;
            case 'dateAsc':
                $query .=" ORDER BY p.created_at ASC";
                break;
            case 'dateDesc':
                $query .=" ORDER BY p.created_at DESC";
                break;
            default:
                $query .= " Order BY p.created_at DESC";
        }

        $query .=" LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        $results = $db->executeQuery($query, $params);

        $products=[];
        foreach($results as $row){
            $products[]= new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }
        return $products;
        
    }

    /**
     * Summary of GetProductsByCategoryWithFiltersAndSort
     * @param Database $db
     * @param int $category_id
     * @param string $sortOption
     * @param Filter[] $filters
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsByCategoryIdPaginatedWithFiltersAndSort(Database $db, int $category_id, string $sortOption, array $filters, int $limit, int $offset): array{
        $query = "SELECT distinct p.*
        From product p
        join variant v on p.id = v.product_id
        Join subcategory sc on p.subcategory_id = sc.id
        where sc.category_id = :category_id";

        $params = [':category_id' => $category_id];
        $i = 0;

        foreach($filters as $filter){
            $name =(string)$filter->name->value;
            $values = $filter->values;
            $placeholders = [];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists(
                SELECT 1 FROM variant v  
                JOIN variant_attribute va On va.variant_id = v.id
                JOIN attribute a ON a.id = va.attribute_id
                WHERE v.product_id = p.id
                AND a.name = :attr_{$name}
                AND va.value IN (" . implode(',',$placeholders).")
            )";
            $params[":attr_{$name}"] = $name;

        }

        switch($sortOption){
            case 'priceAsc':
                $query .= " ORDER BY v.price ASC";
                break;
            case 'priceDesc':
                $query .=" ORDER BY v.price Desc";
                break;
            case 'dateAsc':
                $query .=" ORDER BY p.created_at ASC";
                break;
            case 'dateDesc':
                $query .=" ORDER BY p.created_at DESC";
                break;
            default:
                $query .= " Order BY p.created_at DESC";
        }
        $query .=" LIMIT :limit OFFSET :offset";

        $params[':limit']= $limit;
        $params[':offset']= $offset;

        $results = $db->executeQuery($query, $params);
        $products = [];
        foreach($results as $row){
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }

        return $products;

    }
    /**
     * Summary of GetProductsByCategoryWithFiltersAndSort
     * @param Database $db
     * @param int $category_id
     * @param string $sortOption
     * @param Filter[] $filters
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsBySubcategoryIdPaginatedWithFiltersAndSort(Database $db, int $subcategory_id, string $sortOption, array $filters, int $limit, int $offset): array{
        $query = "SELECT distinct p.*
        From product p
        join variant v on p.id = v.product_id
        where p.subcategory_id = :subcategory_id";

        $params = [':subcategory_id' => $subcategory_id];
        $i = 0;

        foreach($filters as $filter){
            $name =(string)$filter->name->value;
            $values = $filter->values;
            $placeholders = [];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists(
                SELECT 1 FROM variant v  
                JOIN variant_attribute va On va.variant_id = v.id
                JOIN attribute a ON a.id = va.attribute_id
                WHERE v.product_id = p.id
                AND a.name = :attr_{$name}
                AND va.value IN (" . implode(',',$placeholders).")
            )";
            $params[":attr_{$name}"] = $name;

        }

        switch($sortOption){
            case 'priceAsc':
                $query .= " ORDER BY v.price ASC";
                break;
            case 'priceDesc':
                $query .=" ORDER BY v.price Desc";
                break;
            case 'dateAsc':
                $query .=" ORDER BY p.created_at ASC";
                break;
            case 'dateDesc':
                $query .=" ORDER BY p.created_at DESC";
                break;
            default:
                $query .= " Order BY p.created_at DESC";
        }
        $query .=" LIMIT :limit OFFSET :offset";

        $params[':limit']= $limit;
        $params[':offset']= $offset;

        $results = $db->executeQuery($query, $params);
        $products = [];
        foreach($results as $row){
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }

        return $products;

    }

    /**
     * Summary of GetProductsByCategoryWithFiltersAndSort
     * @param Database $db
     * @param int $category_id
     * @param string $sortOption
     * @param Filter[] $filters
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsByCategoryIdPaginatedWithFilters(Database $db, int $category_id, array $filters, int $limit, int $offset): array{
        $query = "SELECT distinct p.*
        From product p
        Join subcategory sc on p.subcategory_id = sc.id
        where sc.category_id = :category_id";

        $params = [':category_id' => $category_id];
        $i = 0;

        foreach($filters as $filter){
            $name =(string)$filter->name->value;
            $values = $filter->values;
            $placeholders = [];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists(
                SELECT 1 FROM variant v  
                JOIN variant_attribute va On va.variant_id = v.id
                JOIN attribute a ON a.id = va.attribute_id
                WHERE v.product_id = p.id
                AND a.name = :attr_{$name}
                AND va.value IN (" . implode(',',$placeholders).")
            )";
            $params[":attr_{$name}"] = $name;
        }
        

        $query .=" LIMIT :limit OFFSET :offset";

        $params[':limit']= $limit;
        $params[':offset']= $offset;

        $results = $db->executeQuery($query, $params);
        $products = [];
        foreach($results as $row){
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }

        return $products;

    }

     /**
     * Summary of GetProductsByCategoryWithFiltersAndSort
     * @param Database $db
     * @param int $category_id
     * @param string $sortOption
     * @param Filter[] $filters
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public static function GetProductsBySubcategoryIdPaginatedWithFilters(Database $db, int $subcategory_id, array $filters, int $limit, int $offset): array{
        $query = "SELECT distinct p.*
        From product p
        where p.subcategory_id = :subcategory_id";

        $params = [':subcategory_id' => $subcategory_id];
        $i = 0;

        foreach($filters as $filter){
            $name =(string)$filter->name->value;
            $values = $filter->values;
            $placeholders = [];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists(
                SELECT 1 FROM variant v  
                JOIN variant_attribute va On va.variant_id = v.id
                JOIN attribute a ON a.id = va.attribute_id
                WHERE v.product_id = p.id
                AND a.name = :attr_{$name}
                AND va.value IN (" . implode(',',$placeholders).")
            )";
            $params[":attr_{$name}"] = $name;
        }

        $query .=" LIMIT :limit OFFSET :offset";

        $params[':limit']= $limit;
        $params[':offset']= $offset;

        $results = $db->executeQuery($query, $params);
        $products = [];
        foreach($results as $row){
            $products[] = new Product($row['id'], $row['subcategory_id'], $row['name'], $row['description'], new DateTime($row['created_at']));
        }

        return $products;

    }

    /**
     * Summary of CountProductsByCategoryIdWithFiltersAndSort
     * @param Database $db
     * @param int $categoryId
     * @param string $sortOption
     * @param Filter[] $filters
     * @return int
     */
    public static function CountProductsBySubcategoryIdWithFilters(Database $db, int $subcategory_id, array $filters):int{
        $query ="SELECT COUNT(distinct p.id) as count from product p
        
        WHERE p.subcategory_id = :subcategory_id";

        $params=[':subcategory_id' => $subcategory_id];
        $i = 0;
        foreach($filters as $filter){
            $name =(string) $filter->name->value;
            $values = $filter->values;
            $placeholders =[];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists(
            SELECT 1 FROM variant v
            join variant_attribute va  on va.variant_id = v.id
            join attribute a on a.id = va.attribute_id
            where v.product_id = p.id
            and a.name = :attr_{$name}
            and va.value IN (".implode(',', $placeholders).")
            )";
            $params[":attr_{$name}"] = $name;
        }

        $results = $db->executeQuery($query, $params);
        return isset($results[0]['count']) ? (int)$results[0]['count'] : 0;
       
    }

    /**
     * Summary of CountProductsByCategoryIdWithFiltersAndSort
     * @param Database $db
     * @param int $categoryId
     * @param string $sortOption
     * @param Filter[] $filters
     * @return int
     */
    public static function CountProductsByCategoryIdWithFilters(Database $db, int $category_id, array $filters):int{
        $query ="SELECT COUNT(distinct p.id) as count from product p
        JOIN subcategory sc ON p.subcategory_id = sc.id
        WHERE sc.category_id = :category_id";

        $params=[':category_id' => $category_id];
        $i = 0;
        foreach($filters as $filter){
            $name =(string) $filter->name->value;
            $values = $filter->values;
            $placeholders =[];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists(
            SELECT 1 FROM variant v
            join variant_attribute va  on va.variant_id = v.id
            join attribute a on a.id = va.attribute_id
            where v.product_id = p.id
            and a.name = :attr_{$name}
            and va.value IN (".implode(',', $placeholders).")
            )";
            $params[":attr_{$name}"] = $name;
        }

        $results = $db->executeQuery($query, $params);
        return isset($results[0]['count']) ? (int)$results[0]['count'] : 0;
       
    }



    public static function CountProductByNameWithFilters($db, string $input, array $filters):int{
        $query = "SELECT COUNT(distinct p.id) as count from product p  where p.name like :input";
        $params = ['input' => "%$input%"];
        $i = 0;
        foreach($filters as $filter){
            $name = (string)$filter->name->value;
            $values = $filter->values;
            $placeholders = [];
            foreach($values as $value){
                $param = ":{$name}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $value;
                $i++;
            }
            $query .=" AND exists (
                SELECT 1 FROM variant v join variant_attribute va 
                on va.variant_id = v.id join attribute a 
                on a.id = va.attribute_id 
                where v.product_id = p.id
                and a.name = :attr_{$name} 
                and va.value IN (".implode(',',$placeholders)."))";
            $params[":attr_{$name}"] = $name;
        }
        $results = $db->executeQuery($query, $params);

        
        return isset($results[0]['count'])? (int)$results[0]['count'] : 0 ;
    }


    public static function CountProductByName(Database $db, string $input):int{
        $query ="SELECT count(*) as count from product WHERE name like :input";
        $params=[
            ":input" =>"%{$input}%"
        ];
        $results =$db->executeQuery($query,$params);
        return isset($results[0]['count']) ? (int)$results[0]['count'] : 0;
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