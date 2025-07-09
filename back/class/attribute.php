<?php

class FilterAttribute{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name){
        $this->id = $id;
        $this->name = $name;
    }

    public function GetId(): int{
        return $this->id;
    }
}