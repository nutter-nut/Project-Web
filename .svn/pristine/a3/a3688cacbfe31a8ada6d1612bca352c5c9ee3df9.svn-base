<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nantaburi\Mongodb\MongoNativeDriver\Model as NanModel ;

class User_nan extends NanModel
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mongodb";

    protected $database = "abpon01" ;
    
    protected $collection = 'users';

    protected $fillable = [
        'id', 'admin', 'employee', 'sale', 'name', 'prefix', 'first_name', 'last_name', 'email', 'tel', 'password', 'status', 'image', 'language', 'banned_until'
    ];

    protected $schema = [
        'users' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                'Index' => true,
                'Unique' => true
            ],
            "admin",
            "employee",
            "sale",
            "status",
            "language",
            "name",
            "prefix",
            "first_name",
            "last_name",
            "image",
            "password",
            "email" => [
                'Unique' => true
            ],
            "tel",
            "banned_until",
            "created_at",
            "updated_at",
        ],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->admin;
    }

    public function isEmployee()
    {
        return $this->employee;
    }
}

