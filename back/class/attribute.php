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


}