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
    
}