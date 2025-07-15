<?php

class HomeCategory{
    public Category $category;
    public VariantImage $variantImage;

    public function __construct(Category $category, VariantImage $variantImage){
        $this->category = $category;
        $this->variantImage = $variantImage;
    }
}