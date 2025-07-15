<?php


class ProductCard{
    public Product $product;
    public ProductVariant $variant;
    public VariantImage $variantImage;
    /**
     * Summary of productAttribute
     * @var VariantAttribute[]
     */
    public array $productAttributes;

    /**
     * Summary of __construct
     * @param Product $product
     * @param VariantImage $productImage
     * @param VariantAttribute[] $productAttributes
     */
    public function __construct(Product $product,ProductVariant $variant, VariantImage $variantImage,  array $productAttributes){
        $this->product = $product;
        $this->variant = $variant;
        $this->variantImage = $variantImage;
        $this->productAttributes = $productAttributes;
    }
}