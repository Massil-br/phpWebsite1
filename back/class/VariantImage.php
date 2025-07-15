<?php

class VariantImage{
    private int $id;
    private int $variant_id;
    private string $image_name;
    private string $alt_text;
    private int $position; 
    

    public static string $folder = './assets/VariantImages/';
    
    public function __construct(int $id, int $variant_id,
     string $image_name, string $alt_text,int $position){
        $this->id = $id;
        $this->variant_id = $variant_id;
        $this->image_name = $image_name;
        $this->alt_text = $alt_text;
        $this->position = $position;
        
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