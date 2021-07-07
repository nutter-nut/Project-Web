<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;
// use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01";
 
    protected $collection = 'products';

    protected $schema = [
        'products' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                // 'Index' => true,
                'Unique' => true
            ],
            "prodCode",
            "uomCode",
            "uomName",
            "prodTName",
            "prodGroupCode",
            "prodUnitRatio",
            "prodUnitPrice", // ราคาที่สร้าง
            "prodIsVat",
            "promotion",
            "price_promotion", // ราคาที่คิดโปรโมชั่น
            "price_vat", // ราคาที่คิดภาษี
            "discount",
            "price", // ราคาขาย
            "review_count",
            "review_count_star",
            "ratting_product",
            "image",
            "ratting",
            "details",
            "best_seller",
            "created_at",
            "updated_at",
        ],
    ];
    
}
