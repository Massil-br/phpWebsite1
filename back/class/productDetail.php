<?php

class ProductDetail{
    public Product $product;
    /**
     * Summary of productImages
     * @var ProductImage[]
     */
    public array $productImages;
    /**
     * Summary of attributes
     * @var Attribute[]
     */
    public array $attributes;
    /**
     * Summary of productAttributes
     * @var ProductAttribute[]
     */
    public array $productAttributes;
    /**
     * Summary of __construct
     * @param Product $product
     * @param ProductImage[] $productImages
     * @param Attribute[] $attributes
     * @param ProductAttribute[] $productAttributes
     */
    public function __construct(Product $product, array $productImages, array $attributes, array $productAttributes){
        $this->product = $product;
        $this->productImages = $productImages;
        $this->attributes = $attributes;
        $this->productAttributes = $productAttributes;
    }
    
}