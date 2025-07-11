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


}