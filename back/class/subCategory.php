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

    public function GetName():string{
        return $this->name;
    }
}