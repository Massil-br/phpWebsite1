<?php

class ProductImage{
    private int $id;
    private int $product_id;
    private string $image_name;
    private string $alt_text;
    private int $position; 
    private DateTime $created_at;

    public static string $folder = './assets/ProductImage/';
    
    public function __construct(int $id, int $product_id,
     string $image_name, string $alt_text,int $position, DateTime $created_at ){
        $this->id = $id;
        $this->product_id = $product_id;
        $this->image_name = $image_name;
        $this->alt_text = $alt_text;
        $this->position = $position;
        $this->created_at = $created_at;
    }

    public function GetImageName(): string{
        return $this->image_name;
    }

    public function GetRelativeUrl(): string{
       return  self::$folder . $this->image_name;
    }

    public function GetPosition():int{
        return $this->position;
    }

    public function GetAlt():string{
        return $this->alt_text;
    }
}