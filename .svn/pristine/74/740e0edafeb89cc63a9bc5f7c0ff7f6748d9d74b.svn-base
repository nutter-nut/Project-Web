<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Nantaburi\Mongodb\MongoNativeDriver\Model;

class UserActivity extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01";
 
    protected $collection = 'user_activities';

    protected $schema = [
        'user_activities' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                // 'Index' => true,
                'Unique' => true
            ],
            "user_id",
            "type",
            "page",
            "icon",
            "description",
            "created_at",
        ],
    ];

    protected $dispatchesEvents = ['storeActivity' => 'App\Events\User\LogActivity'];
}
