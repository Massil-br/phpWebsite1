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
    public static function GetAttributesByIds(Database $db,array $ids): array{
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

            $results = $db->executeQuery($query, $params);
            $row = $results[0];

            $attributes[]= new FilterAttribute($row['id'], $row['name']);

        }

        return $attributes;
        
    }


}