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


}