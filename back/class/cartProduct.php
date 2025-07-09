<?php


class CartProduct{
    private int $id;
    private int $cart_id;
    private int $product_id;
    private int $quantity;

    public function __construct(int $id, int $cart_id, int $product_id, int $quantity){
        $this->id = $id;
        $this->cart_id = $cart_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function GetProductId():int{
        return $this->product_id;
    }
    public function GetQuantity(): int{
        return $this->quantity;
    }


}