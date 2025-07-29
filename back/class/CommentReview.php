<?php


class CommentReview{
    public ProductReview $productReview;
    public ProductComment|null $productComment;
    public string|null $userFirstName;
    public function __construct(ProductReview $productReview, ProductComment|null $productcomment, string|null $userFirstName){
        $this->productReview = $productReview;
        $this->productComment = $productcomment;
        $this->userFirstName = $userFirstName;
    }
    
}