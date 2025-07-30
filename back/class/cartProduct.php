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

    public function GetId():int{
        return $this->id;
    }
    public function GetProductId():int{
        return $this->product_id;
    }
    public function GetQuantity(): int{
        return $this->quantity;
    }
    public function GetCartId():int{
        return $this->cart_id;
    }

    public static function AddProductToCart(Database $db, int $cart_id, int $product_id, int $quantity){
        $query = "INSERT INTO cart_product (product_id, quantity, cart_id)
          VALUES (:product_id, :quantity, :cart_id)
          ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
        $params =[
            ':product_id'=>$product_id,
            ':quantity'=>$quantity,
            ':cart_id'=>$cart_id
        ];
        $db->executeQuery($query, $params);
    }


}