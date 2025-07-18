<?php

enum FilterName:string{
    case COLOR = 'color';
    case SIZE = 'size';
    
}


class Filter{
    public FilterName $name;
    public string $value;

    public function __construct(FilterName $name, string $value){
        $this->name = $name;
        $this->value = $value;
    }
}

