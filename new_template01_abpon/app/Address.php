<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;
// use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01" ;
 
    protected $collection = 'address';

    protected $schema = [
        'address' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                // 'Index' => true,
                'Unique' => true
            ],
            "user_id",
            "place_name",
            "first_name",
            "last_name",
            "phone",
            "address",
            "created_at",
            "updated_at",
        ],
    ];
    
}
