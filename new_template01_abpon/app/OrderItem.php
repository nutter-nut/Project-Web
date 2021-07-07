<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;

class OrderItem extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01";

    protected $collection = "order_items";  

    protected $schema = [
        'order_items' => [
            "id" => [
                'AutoInc' => true,
                'Unique' => true
            ],
            "product_id",
            "order_id",
            "product_quantity",
            "product_name",
            "product_price",
            "product_total",
            "product_uomName",
            "product_uomCode",
            "created_at",
            "updated_at",
        ],
    ];
}
