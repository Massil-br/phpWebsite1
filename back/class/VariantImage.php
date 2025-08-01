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


    public static function GetProductFirstImage(Database $db,int $product_id): VariantImage{
        
        $query ="SELECT vi.* from variant_image vi 
        Join variant v on v.id = vi.variant_id 
        where v.product_id = :product_id 
        and vi.position = 1 order by v.id asc limit 1";

        $params = [':product_id' => $product_id];
        $results = $db->executeQuery($query,$params);

        if(empty($results)){
            throw new ErrorException("no images found in database");
        }
        $row = $results[0];
        return new VariantImage($row['id'],$row['variant_id'], $row['image_name'], $row['alt_text'],$row['position']);

        
    }
    public static function GetProductFirstImageByVariantId(Database $db,int $variant_id): VariantImage{
        
        $query ="SELECT vi.* from variant_image vi 
        Join variant v on v.id = vi.variant_id 
        where v.id = :variant_id 
        and vi.position = 1 order by v.id asc limit 1";

        $params = [':variant_id' => $variant_id];
        $results = $db->executeQuery($query,$params);

        if(empty($results)){
            throw new ErrorException("no images found in database");
        }
        $row = $results[0];
        return new VariantImage($row['id'],$row['variant_id'], $row['image_name'], $row['alt_text'],$row['position']);

        
    }


    /**
     * Summary of GetProductImages
     * @param int $id
     * @return VariantImage[]
     */
    public static function GetProductImages(Database $db,int $product_id): array{
        
        $query = "SELECT vi.* from variant_image vi join variant v on v.id = vi.variant_id where v.product_id = :product_id";

        $params = [':product_id' => $product_id];
        $results = $db->executeQuery($query, $params);

        $productimages=[];
        foreach($results as $row){
            $productimages[] = new VariantImage($row['id'],$row['variant_id'],$row['image_name'], $row['alt_text'], $row['position']);
        }
        
        return $productimages;

    }


    

        public static  function GetRandImageByCategoryId(Database $db,$category_id): VariantImage{
        $query ="SELECT id from subcategory WHERE category_id =:id ORDER BY RAND() LIMIT 1";
        $params =[
            ":id" => $category_id
        ];
        $results = $db->executeQuery($query, $params);
        if(empty($results)){
           throw new ErrorException("no subcategory found for category id : $category_id"); 
        }
        $subcategoryId = $results[0]['id'];

        $query ="SELECT id from product WHERE subcategory_id = :subcategory_id order by RAND() LIMIT 1 ";
        $params=[
            ":subcategory_id" => $subcategoryId
        ];
        $results = $db->executeQuery($query,$params);
        if(empty($results)){
           throw new ErrorException("no product found for subcategory id : $subcategoryId"); 
        }
        $productId = $results[0]['id'];

        $query = "SELECT id from variant where product_id = :product_id order by RAND() LIMIT 1";
        $params =[
            "product_id" => $productId
        ];
        $results = $db->executeQuery($query,$params);
        if(empty($results)){
           throw new ErrorException("no variant found for product id : $productId"); 
        }
        $variantId = $results[0]['id'];


        $query = "SELECT * from variant_image where variant_id =:variant_id and position = 1";
        $params = [
            "variant_id" =>$variantId
        ];
        $results = $db->executeQuery($query, $params);
        if(empty($results)){
           throw new ErrorException("no variant_image found for variant id : $variantId"); 
        }
        $row = $results[0];
        $variantImage = new VariantImage($row['id'],$row['variant_id'], $row['image_name'], $row['alt_text'], $row['position']);
        return $variantImage;
    }



}