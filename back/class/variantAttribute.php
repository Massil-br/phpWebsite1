<?php

class VariantAttribute{
    private int $id;
    private int $variant_id;
    private int $attribute_id;
    private string $value;

    public function __construct(int $variant_id, int $attribute_id, string $value ){
        $this->variant_id = $variant_id;
        $this->attribute_id = $attribute_id;
        $this->value = $value;
    }

    public function GetId():int{
        return $this->id;
    }
    public function GetValue(): string{
        return $this->value;
    }

    public function GetAttributeId():int{
        return $this->attribute_id;
    }

    /**
     * Summary of GetProductAttributes
     * @param int $id
     * @return VariantAttribute[]
     */
    public static function GetVariantAttributes(Database $db,int $id):array{
        $query = "SELECT * FROM variant_attribute WHERE variant_id = :id";
        $params =[
            ':id'=> $id
        ];

        $results = $db->executeQuery($query, $params);

        $productAttributes = [];
        foreach($results as $row){
            $productAttributes[] = new VariantAttribute($row['variant_id'],$row['attribute_id'], $row['value']);
        }
        return $productAttributes;

    }


}