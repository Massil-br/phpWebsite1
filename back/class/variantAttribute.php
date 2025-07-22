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

    /**
     * Summary of GetVariantAttributesByAttributeId
     * @param Database $db
     * @param int $attribute_id
     * @return VariantAttribute[]
     */
    public static function GetVariantAttributesByAttributeId(Database $db, int $attribute_id):array{
        //$query = "SELECT distinct * from variant_attribute where attribute_id = :attribute_id";
        $query ="SELECT va.* from variant_attribute va 
        INNER JOIN(
            SELECT MIN(variant_id) as variant_id, value
            FROM variant_attribute
            WHERE attribute_id = :attribute_id
            GROUP BY value
        )
        as unique_va on va.variant_id = unique_va.variant_id and va.value = unique_va.value where va.attribute_id = :id";
        $params = [':attribute_id' =>$attribute_id,':id' =>$attribute_id];
        $results =$db->executeQuery($query, $params);
        $variantAttributes = [];
        foreach($results as $row){
            $variantAttributes[]= new VariantAttribute($row['variant_id'], $row['attribute_id'], $row['value']);
        }
        return $variantAttributes;
    }

    /**
     * Summary of GetVariantAttributesByCategoryAndAttributeId
     * @param Database $db
     * @param int $category_id
     * @param int $attribute_id
     * @return VariantAttribute[]
     */
    public static function GetVariantAttributesByCategoryAndAttributeId(Database $db, int $category_id, int $attribute_id):array{
        $query = "SELECT  va.* from variant_attribute va
            Join variant v on va.variant_id = v.id
            Join product p on v.product_id = p.id
            Join subcategory sc on p.subcategory_id = sc.id
            Where sc.category_id = :category_id and va.attribute_id = :attribute_id
            Group by va.value
            Order by va.value
        ";
        $params = [':category_id'=>$category_id, ':attribute_id' => $attribute_id];
        $results = $db->executeQuery($query,$params);
        $variantAttributes = [];
        foreach($results as $row){
            $variantAttributes[]= new VariantAttribute($row['variant_id'], $row['attribute_id'], $row['value']);
        }
        return $variantAttributes;
    }

    /**
     * Summary of GetVariantAttributesBySubCategoryAndAttributeId
     * @param Database $db
     * @param int $subcategory_id
     * @param int $attribute_id
     * @return VariantAttribute[]
     */
    public static function GetVariantAttributesBySubCategoryAndAttributeId(Database $db, int $subcategory_id, int $attribute_id):array{
        $query = "SELECT  va.* from variant_attribute va
            Join variant v on va.variant_id = v.id
            Join product p on v.product_id = p.id
            Where p.subcategory_id = :subcategory_id and va.attribute_id = :attribute_id
            Group by va.value
            Order by va.value
        ";
        $params = [':subcategory_id'=>$subcategory_id, ':attribute_id' => $attribute_id];
        $results = $db->executeQuery($query,$params);
        $variantAttributes = [];
        foreach($results as $row){
            $variantAttributes[]= new VariantAttribute($row['variant_id'], $row['attribute_id'], $row['value']);
        }
        return $variantAttributes;
    }

    /**
     * Summary of GetVariantAttributesBySearchAndAttributeId
     * @param Database $db
     * @param string $input
     * @param int $attribute_id
     * @return VariantAttribute[]
     */
    public static function GetVariantAttributesBySearchAndAttributeId(Database $db, string $input, int $attribute_id):array{
        $query = "SELECT va.* from variant_attribute va
            Join variant v on va.variant_id = v.id
            Join product p on v.product_id = p.id
            Where p.name like :input and va.attribute_id = :attribute_id
            Group by va.value
            Order by va.value
        ";
        $params = [':input'=>"%{$input}%", ':attribute_id' => $attribute_id];
        $results = $db->executeQuery($query,$params);
        $variantAttributes = [];
        foreach($results as $row){
            $variantAttributes[]= new VariantAttribute($row['variant_id'], $row['attribute_id'], $row['value']);
        }
        return $variantAttributes;
    }


}