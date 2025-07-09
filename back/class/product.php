<?php 


class Product{
    private int $id;
    private int $subcatecory_id;
    private string $name;
    private string $description;
    private float $price;
    private int $stock;
    private DateTime $created_at;

    public function __construct(int $id, int $subcatecory_id, 
    string $name, string $description, float $price,int $stock, DateTime $created_at){
        $this->id = $id;
        $this->subcatecory_id = $subcatecory_id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->created_at = $created_at;
    }

    public function GetId():int{
        return $this->id;
    }


    public function GetName():string{
        return $this->name;
    }

    public function GetPrice(): float{
        return $this->price;
    }

    public function GetDescription():string{
        return $this->description;
    }

    public function GetStock(): int{
        return $this->stock;
    }


    
}