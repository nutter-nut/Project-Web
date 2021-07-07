<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;
// use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $connection = "mongodb";

    protected $database = "abpon01";
    
    protected $collection = "messages";

    protected $schema = [
            'messages' => [
                "id" => [
                    'AutoInc' => true,
                    // 'AutoIncStartwith' => 10,
                    // 'Index' => true,
                    'Unique' => true
                ],
                "user_id",
                "session",
                "message",
                "status",
                "created_at",
                "updated_at"
            ],
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
