<?php

class ProductAttribute{
    private int $product_id;
    private int $attribute_id;
    private string $value;

    public function __construct(int $product_id, int $attribute_id, string $value ){
        $this->product_id = $product_id;
        $this->attribute_id = $attribute_id;
        $this->value = $value;
    }

    public function getValue(): string{
        return $this->value;
    }

    public function GetAttributeId():int{
        return $this->attribute_id;
    }

}