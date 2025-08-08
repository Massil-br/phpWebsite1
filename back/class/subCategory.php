<?php 

class SubCategory{
    private int $id;
    private int $category_id;
    private string $name;
    private string $description;
    private DateTime $created_at;

    public function __construct(int $id, int $category_id, string $name, string $description, DateTime $created_at){
        $this->id = $id;
        $this->category_id = $category_id;
        $this->name = $name;
        $this->description = $description;
        $this->created_at = $created_at;
    }

    public function GetId():int{
        return $this->id;
    }
    public function GetCategoryId():int{
        return $this->category_id;
    }
    public function GetDescription():string{
        return $this->description;
    }

    public function GetName():string{
        return $this->name;
    }

    /** @return SubCategory[] */
    public static function getSubCategories(Database $db, int $category_id): array{
        $query = "SELECT * FROM subcategory WHERE category_id = :category_id";
        $params = [
            ':category_id' => $category_id
        ];
        $results = $db->executeQuery($query,$params);

        $subcategories = [];
        foreach($results as $row){
            $createdAt = new DateTime($row['created_at']);
            $subcategories[]= new SubCategory($row['id'], $row['category_id'], $row['name'], $row['description'],$createdAt);
        }
        return $subcategories;
    }

    /**
     * Summary of GetAllSubcategories
     * @param Database $db
     * @return SubCategory[]
     */
    public static function GetAllSubcategories(Database $db):array{
        $query = "SELECT * FROM subcategory";
        $results = $db->executeQuery($query);
        $subcategories = [];
        if(empty($results)){
            return $subcategories;
        }
        foreach($results as $row){
            $subcategories[]= new SubCategory($row['id'],$row['category_id'],$row['name'],$row['description'],new DateTime($row['created_at']));
        }
        return $subcategories;
    }


}