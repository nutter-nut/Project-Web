<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

use App\User;
use App\User_nan;

$factory->define(User::class, function (Faker $faker) {
    return [
        'id' => User_nan::database()->collection("users")->getModifySequence('id'),
        'admin' => 0,
        'sale' => 0,
        'name' => $faker->name,
        'status' => 'offline',
        'image' => 'default.jpg',
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('123456'),
        'remember_token' => Str::random(10),
    ];
});