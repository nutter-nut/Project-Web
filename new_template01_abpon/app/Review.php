<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;
// use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $connection = "mongodb";

    protected  $database = "abpon01";

    protected  $collection = "reviews";  

    protected $schema = [
        'reviews' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 101,
                // 'Index' => true,
                'Unique' => true
            ],
            "prodCode",
            "user_id",
            "text",
            "ratting",
            "created_at",
            "updated_at",
        ],
    ];
}
