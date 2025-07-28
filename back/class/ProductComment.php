<?php

class ProductComment{
    private int $id;
    private int $product_id;
    private int $user_id;
    private string $comment;
    private int $product_review_id;

    public function __construct(int $id, int $product_id, int $user_id, string $comment, int $product_review_id){
        $this->id = $id;
        $this->$product_id = $product_id;
        $this->user_id = $user_id;
        $this->comment = $comment;
        $this->product_review_id = $product_review_id;
    }

    public function GetProductCommentsByProductId(Database $db, int $product_id):array{
        $query = "SELECT * FROM product_comment WHERE product_id = :product_id";
        $params = [':product_id'=>$product_id];
        $results = $db->executeQuery($query, $params);
        if (empty($results)){
            return [];
        }
        $productComments = [];
        foreach($results as $row){
            $productComments[]= new ProductComment($row['id'], $row['product_id'], $row['user_id'], $row['comment'], $row['product_review_id']);
        }
        return $productComments;
    }
}