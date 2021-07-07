<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;
// use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01" ;
 
    protected $collection = 'webhook';

    protected $schema = [
        'webhook' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                // 'Index' => true,
                'Unique' => true
            ],
            "order_id",
            "transectionID",
            "amount",
            "status",
            "hash",
            "created_at",
        ],
    ];
}
