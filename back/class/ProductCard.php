<?php


class ProductCard{
    public Product $product;
    public ProductImage $productImage;
    /**
     * Summary of productAttribute
     * @var ProductAttribute[]
     */
    public array $productAttributes;

    /**
     * Summary of __construct
     * @param Product $product
     * @param ProductImage $productImage
     * @param ProductAttribute[] $productAttributes
     */
    public function __construct(Product $product, ProductImage $productImage, array $productAttributes){
        $this->product = $product;
        $this->productImage = $productImage;
        $this->productAttributes = $productAttributes;
    }
}