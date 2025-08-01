<?php


class CartProduct{
    private int $id;
    private int $cart_id;
    private int $variant_id;
    private int $quantity;
    /**
     * Summary of variantAttributes
     * @var VariantAttribute[]
     */
    public array $variantAttributes;

    public function __construct(int $id, int $cart_id, int $variant_id, int $quantity,array $variantAttributes){
        $this->id = $id;
        $this->cart_id = $cart_id;
        $this->variant_id = $variant_id;
        $this->quantity = $quantity;
        $this->variantAttributes = $variantAttributes;
    }

    public function GetId():int{
        return $this->id;
    }
    public function GetVariantId():int{
        return $this->variant_id;
    }
    public function GetQuantity(): int{
        return $this->quantity;
    }
    public function GetCartId():int{
        return $this->cart_id;
    }

    public function GetProductId():int{
        global $db;
        $query = "SELECT p.id From product p 
        Join variant v on v.product_id = p.id WHERE v.id = :id";
        $params =[':id'=>$this->variant_id];
        $results = $db->executeQuery($query, $params);
        if (empty($results)){
            throw new ErrorException("no Product found for this vriant id $this->variant_id");
        }
        return $results[0]['id'];
        
    }

   
    /**
     * Summary of AddProductToCart
     * @param Database $db
     * @param int $cart_id
     * @param int $variant_id
     * @param int $quantity
     * @param int[] $variantAttributesIds
     * @return void
     */
    public static function AddProductToCart(Database $db, int $cart_id, int $variant_id, int $quantity ,array $variantAttributesIds): void{
        $idstring = implode(',',$variantAttributesIds);
        $query = "INSERT INTO cart_product (variant_id, quantity, cart_id, variant_attribute_ids)
          VALUES (:variant_id, :quantity, :cart_id, :variant_attribute_ids)
          ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
        $params =[
            ':variant_id'=>$variant_id,
            ':quantity'=>$quantity,
            ':cart_id'=>$cart_id,
            ':variant_attribute_ids'=>$idstring
        ];
        $db->executeQuery($query, $params);
    }

    public static function GetCartProductsByCartId(Database $db, int $cart_id):array{
        $query = "SELECT * FROM cart_product WHERE cart_id = :cart_id";
        $params = [':cart_id'=>$cart_id];
        $results = $db->executeQuery($query, $params);
        if(empty($results)){
            return [];
        }
        $cartProducts = [];
        foreach($results as $row){
            $variantAttributes = [];
            if(!empty($row['variant_attribute_ids'])){
                $ids = explode(',', $row['variant_attribute_ids']);
                foreach($ids as $id){
                    $attr = VariantAttribute::GetVariantAttributeById($db, (int)$id);
                    if($attr!== null){
                        $variantAttributes[]=$attr;
                    }
                }
            }
            $cartProducts[]= new CartProduct($row['id'], $row['cart_id'], $row['variant_id'],$row['quantity'], $variantAttributes);
        }
        return $cartProducts;
    }

    public static function DeleteCartProductById(Database $db, int $cart_product_id): void{
        $query = "DELETE from cart_product WHERE id = :id";
        $params =[':id'=>$cart_product_id];
        $db->executeQuery($query, $params);
    }

    

    public function SetQuantity(int $quantity): void{
        global $db;
        $query = "UPDATE cart_product set quantity = :quantity WHERE id = $this->id";
        $params =[':quantity'=>$quantity];
        $db->executeQuery($query, $params);
    }


}