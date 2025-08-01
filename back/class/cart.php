<?php


class Cart{
    private int $id;
    private int $user_id;

    public function __construct(int $id, int $user_id){
        $this->id = $id;
        $this->user_id = $user_id;
    }

    public function GetId(): int{
        return $this->id;
    }

    public static function CreateCartIfNotExists(Database $db, int $user_id): void{
        $query = "INSERT into cart (user_id) values (:user_id)";
        $params=[':user_id'=>$user_id];
        $db->executeQuery($query,$params);
    }
    public static function GetCartIdByUserId(Database $db , int $user_id):int{
        $query = "SELECT id FROM cart WHERE user_id = :user_id";
        $params =[':user_id'=>$user_id];
        $results = $db->executeQuery($query,$params);
        if(empty($results)){
            return -1;
        }
        return $results[0]['id'];
    }


}