<?php

class ProductDetail{
    public Product $product;
    /**
     * Summary of variants
     * @var ProductVariant[]
     */
    public array $variants;
    /**
     * Summary of productImages
     * @var VariantImage[]
     */
    public array $variantImages;
    /**
     * Summary of attributes
     * @var Attribute[]
     */
    public array $attributes;
    /**
     * Summary of productAttributes
     * @var VariantAttribute[]
     */
    public array $variantAttributes;
    /**
     * Summary of __construct
     * @param Product $product
     * @param ProductVariant[] $variants
     * @param variantImage[] $productImages
     * @param Attribute[] $attributes
     * @param VariantAttribute[] $productAttributes
     */
    public function __construct(Product $product, array $variants, array $variantImages, array $attributes, array $variantAttributes){
        $this->product = $product;
        $this->variants = $variants;
        $this->variantImages = $variantImages;
        $this->attributes = $attributes;
        $this->variantAttributes = $variantAttributes;
    }
    
}