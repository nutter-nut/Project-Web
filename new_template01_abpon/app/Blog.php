<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;
// use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01" ;
 
    protected $collection = 'blogs';

    protected $schema = [
        'blogs' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                // 'Index' => true,
                'Unique' => true
            ],
            "user_id",
            "like",
            "date",
            "title",
            "description",
            "image",
            "products",
            "created_at",
            "updated_at",
        ],
    ];
    
}
