<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;
// use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01" ;
 
    protected $collection = 'categories';

    protected $schema = [
        'categories' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                // 'Index' => true,
                'Unique' => true
            ],
            "name",
            "created_at",
            "updated_at",
        ],
    ];

}
