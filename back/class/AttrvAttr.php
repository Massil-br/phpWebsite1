<?php

class AttrvAttr{
    public FilterAttribute $attribute;

    /**
     * Summary of variantAttributes
     * @var VariantAttribute[]
     */
    public array $variantAttributes;

    /**
     * Summary of __construct
     * @param FilterAttribute $attribute
     * @param VariantAttribute[] $variantAttributes
     */
    public function __construct(FilterAttribute $attribute, array $variantAttributes){
        $this->attribute = $attribute;
        $this->variantAttributes = $variantAttributes;
    }





}