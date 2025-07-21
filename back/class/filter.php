<?php

enum FilterName:string{
    case COLOR = 'color';
    case SIZE = 'size';
    
}


class Filter{
    public FilterName $name;
    /**
     * Summary of value
     * @var string[]
     */
    public array $values;

    /**
     * Summary of __construct
     * @param FilterName $name
     * @param string[] $value
     */
    public function __construct(FilterName $name, array $values){
        $this->name = $name;
        $this->values = $values;
    }
}

