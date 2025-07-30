<?php

class ProductReviewStars{
    public static $stars1 = '1';
    public static $stars2 = '2';
    public static $stars3 = '3';
    public static $stars4 = '4';
    public static $stars5 = '5';
}


class ProductReview{
    private int $id;
    private int $product_id;
    private int $user_id;
    private string $stars;

    public function __construct(int $id, int $product_id, int $user_id, string $stars){
        $this->id = $id;
        $this->product_id = $product_id;
        $this->user_id = $user_id;
        $this->stars = $stars;
    }

    public function GetId():int{
        return $this->id;
    }
    public function GetProductId():int{
        return $this->product_id;
    }
    public function GetUserId():int{
        return $this->user_id;
    }
    public function GetStars():string{
        return $this->stars;
    }

    /**
     * Summary of GetProductReviewsByProductID
     * @param Database $db
     * @param int $product_id
     * @return ProductReview[]
     */
    public static function GetProductReviewsByProductID(Database $db, int $product_id):array{
        $query="SELECT * From product_review where product_id = :product_id";
        $params = [':product_id'=> $product_id];
        $results = $db->executeQuery($query,$params);
        if(empty($results)){
            return [];
        }
        $productReviews = [];
        foreach($results as $row){
            $productReviews[]=new ProductReview($row['id'], $row['product_id'], $row['user_id'], $row['stars']);
        }
        return $productReviews;
    }
    public static function CreateProductReview(Database $db, int $product_id, int $user_id, string $stars): int{
        $query ="INSERT into product_review (product_id, user_id, stars) values (:product_id, :user_id, :stars)";
        $params =[
            ':product_id'=> $product_id,
            ':user_id'=>$user_id,
            ':stars'=>$stars
        ];

        $db->executeQuery($query, $params);
        $id = $db->lastInsertId();
        return $id;
    }
}