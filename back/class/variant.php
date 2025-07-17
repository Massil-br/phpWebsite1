<?php
class ProductVariant{
    private int $id;
    private int $product_id;
    private string $sku;
    private float $price;
    private int $stock;
    private DateTime $created_at;

    public function __construct(int $id, int $product_id, string $sku, float $price, int $stock, string $created_at){
        $this->id  = $id;
        $this->product_id = $product_id;
        $this->sku = $sku;
        $this->price = $price;
        $this->stock = $stock;
        $this->created_at = new DateTime($created_at);
    }

    public function GetId(): int{
        return $this->id;
    }

    public function GetProductId():int{
        return $this->product_id;
    }
    public function GetPrice():float{
        return $this->price;
    }
    public function GetSku():string{
        return $this->sku;
    }

    public function GetStock():int{
        return $this->stock;
    }

    public static  function GetFirstVariantByProductId(Database $db, int $id):ProductVariant{
    $query = "SELECT * FROM variant WHERE product_id = :id";
    $params =[
        ':id' =>$id
    ];

    $results = $db->executeQuery($query, $params);
    if(isset($results[0])){
        $row = $results[0];
        $variant = new ProductVariant($row['id'], $row['product_id'], $row['sku'], $row['price'], $row['stock'], $row['created_at']);
        return $variant;
    }
    throw new ErrorException("no variant found for this product, product_id : $id");
        
    }


    /**
     * Summary of GetProductVariantsByProductId
     * @param int $id
     * @return ProductVariant[]
     */
    public static  function GetProductVariantsByProductId(Database $db,int $id):array{
        $query = "SELECT * FROM variant WHERE product_id =:id";
        $params =[
            ':id' => $id
        ];

        $results = $db->executeQuery($query, $params);
        $variants = [];
        foreach($results as $row){
            $variants[] = new ProductVariant($row['id'], $row['product_id'], $row['sku'], $row['price'], $row['stock'], $row['created_at']);
        }
        return $variants;
    }
    
    /**
     * Summary of GetProductVariantsIdsByProductId
     * @param int $id
     * @throws \ErrorException
     * @return int[]
     */
    public static function GetVariantsIdsByProductId(Database $db,int $id):array{
        $query = "SELECT id FROM variant WHERE product_id =:id";
        $params = [
            ':id' =>$id
        ];

        $results = $db->executeQuery($query, $params);
        if (count($results) >0){
            $ids = [];
            foreach($results as $row){
                $ids[] = $row['id'];
            }
            return $ids;
        }
        throw new ErrorException("no variants found for product : $id");
        
    }

}