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



}
