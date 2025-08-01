<?php

class cartProductDisplay{
    public CartProduct $cartProduct;
    public ProductVariant $variant;

    public VariantImage $variantImage;
   

    public function __construct(CartProduct $cartProduct){
        global $db;
        $this->cartProduct = $cartProduct;
        $this->variant = ProductVariant::GetVariantById($db, $cartProduct->GetVariantId());
        $this->variantImage  = VariantImage::GetProductFirstImageByVariantId($db,$cartProduct->GetVariantId());
    }
}
