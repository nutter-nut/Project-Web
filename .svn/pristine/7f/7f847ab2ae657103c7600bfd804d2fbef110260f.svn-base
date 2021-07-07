<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;
// use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01" ;
 
    protected $collection = 'comments';

    protected $schema = [
        'comments' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                // 'Index' => true,
                'Unique' => true
            ],
            "user_id",
            "blog_id",
            "text",
            "created_at",
            "updated_at"
        ],
    ];
}
