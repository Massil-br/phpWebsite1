<?php

class FilterAttribute{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name){
        $this->id = $id;
        $this->name = $name;
    }

    public function GetId(): int{
        return $this->id;
    }
    public function GetName():string{
        return $this->name;
    } 

    /**
     * Summary of GetAttribute
     * @param int[] $ids
     * @return FilterAttribute[]
     */
    public static function GetAttributesByIds(Database $db, array $ids): array {
        $ids = array_unique($ids);
        if (empty($ids)) {
            return [];
        }

        // Ré-indexe proprement les clés pour les paramètres positionnels
        $ids = array_values($ids);

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT * FROM attribute WHERE id IN ($placeholders)";

        $results = $db->executeQuery($query, $ids);

        if ($results === false) {
            throw new Exception("Erreur SQL lors de GetAttributesByIds");
        }

        $attributes = [];
        foreach ($results as $row) {
            $attributes[] = new FilterAttribute($row['id'], $row['name']);
        }

        return $attributes;
    }

    /**
     * Summary of GetAttributesBySearch
     * @param Database $db
     * @param string $input
     * @return FilterAttribute[]
     */
    public static function  GetAttributesBySearch(Database $db, string $input):array{
        $query = "SELECT distinct a.* from attribute a JOIN variant_attribute va on va.attribute_id = a.id Join variant v on va.variant_id = v.id join product p on p.id = v.product_id WHERE p.name like :input";
        $params = [':input' => "%{$input}%"];
        $results = $db->executeQuery($query, $params);

        $filterAttributes = [];
        foreach($results as $row){
            $filterAttributes[] = new FilterAttribute($row['id'], $row['name']);
        }
        return $filterAttributes;
    }

    /**
     * Summary of GetAttributesByCategory
     * @param Database $db
     * @param int $category_id
     * @return FilterAttribute[]
     */
    public static function GetAttributesByCategory(Database $db, int $category_id): array{
        $query="SELECT distinct a.* from attribute a
        join variant_attribute va on va.attribute_id = a.id 
        join variant v on va.variant_id = v.id
        join product p on p.id = v.product_id 
        join subcategory sc on p.subcategory_id = sc.id
        where sc.category_id = :category_id ";
        $params = [':category_id'=>$category_id];
        $results = $db->executeQuery($query,$params);
        $filterAttributes = [];
        foreach($results as $row){
            $filterAttributes[]= new FilterAttribute($row['id'], $row['name']);
        }
        return $filterAttributes;
    }

    public static function GetAttributesBySubcategory(Database $db, int $subcategory_id):array{
        $query = "SELECT distinct a.* from attribute a
        Join variant_attribute va on va.attribute_id = a.id
        Join variant v on va.variant_id = v.id
        Join product p on v.product_id = p.id
        Where p.subcategory_id = :subcategory_id";
        $params =[':subcategory_id' => $subcategory_id];
        $results = $db->executeQuery($query, $params);
        $filterAttributes = [];
        foreach($results as $row){
            $filterAttributes[] = new FilterAttribute($row['id'], $row['name']);
        }
        return $filterAttributes;
    }






}