<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;

class Order extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01";

    protected $collection = "orders";

    protected $schema = [
        'orders' => [
            "id" => [
                'AutoInc' => true,
                'Unique' => true
            ],
            "status",
            "status_payment",
            "document_refer",
            "date",
            "quantity",
            "price",
            "user_id",
            "full_name",
            "address",
            "phone",
            "cart",
            "created_at",
            "updated_at",
        ],
    ];
}
