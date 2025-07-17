<?php

class Category{
    private int $id;
    private string $name;
    private string $description;
    private DateTime $created_at;

    public function __construct(int $id, string $name, string $description, DateTime $created_at){
        $this->id = $id;
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




    /** @return Category[] */
    public static function getCategories(Database $db):array{
        $query = "SELECT * FROM category";
        $results = $db->executeQuery($query);
        $categories = [];
        foreach($results as $row){
            $createdAt = new DateTime($row['created_at']);
            $categories[] = new Category($row['id'], $row['name'],$row['description'], $createdAt);
        }

        return $categories;
    }
    
    /**
     * Summary of Get3RandomCategories
     * @return Category[]
     */
    public static  function Get3RandomCategories(Database $db):array{
        $query ="SELECT * FROM category ORDER BY RAND() LIMIT 3";
        $results = $db->executeQuery($query);
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


}
