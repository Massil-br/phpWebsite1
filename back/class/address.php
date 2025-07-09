<?php 


class Address{
    private int $id;
    private int $user_id;
    private string $street;
    private string $city;
    private string $postal_code;
    private string $country;
    private DateTime $created_at;

    public function __construct(int $id, int $user_id, string $street, string $city, string $postal_code, string $coutry, DateTime $created_at){
        $this->id = $id;
        $this->user_id = $user_id;
        $this->street = $street;
        $this->city = $city;
        $this->postal_code = $postal_code;
        $this->country = $coutry;
        $this->created_at = $created_at;
    }



}