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

    public function GetId():int{
        return $this->id;
    }
    public function GetUserID():int{
        return $this->user_id;
    }

    public static function GetProductCommentsByProductId(Database $db, int $product_id):array{
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

    public static function CreateProductComment(Database $db,int $product_id, int $user_id, int $product_review_id, string $comment){
        $query = "INSERT into product_comment (product_id, user_id, product_review_id, comment) VALUES (:product_id, :user_id, :product_review_id, :comment)";
        $params =[
        ':product_id'=>$product_id,
        ':user_id'=>$user_id,
        ':product_review_id'=>$product_review_id,
        ':comment'=>$comment
        ];

        $db->executeQuery($query, $params);
    }

    public static function GetProductCommentByID(Database $db, $id):ProductComment{
        $query ="SELECT * FOM product_comment WHERE id = :id";
        $params =[':id'=>$id];
        $results = $db ->executeQuery($query, $params);
        if (empty($results)){
            throw new ErrorException("no ProductComment found");
        }
        $row = $results[0];
        $productComment = new ProductComment($row['id'], $row['product_id'], $row['user_id'], $row['comment'],$row['product_review_id']);
        return $productComment;
    }

    public static function DeleteComment(Database $db, int $product_comment_id, int $user_id){
        $user = User::GetUserByID($db, $user_id);
        $productComment = ProductComment::GetProductCommentByID($db,$product_comment_id);
        if($user->getId() !== $productComment->GetUserID()){
            if($user->getRole() !== 'admin' || $user->getRole() !== 'dev'){
                throw new ErrorException("you can't delete this comment");
            }
        }
        $query = "DELETE FROM product_comment WHERE id = :id";
        $params =[':id'=>$product_comment_id];
        $db->executeQuery($query,$params);
    }

}