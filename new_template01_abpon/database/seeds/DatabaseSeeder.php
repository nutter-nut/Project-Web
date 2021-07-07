<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\User;
use App\User_nan;
use App\Categorie;
use App\Message;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserTableSeeder');

        $this->command->info('User table seeded!');
    }

}

class UserTableSeeder extends Seeder {

    public function run() // !php artisan db:seed
    {
        // DB::table('users')->delete();

        // self::createAdmin();

        // self::createUsers(1);

        // self::createCategories(1);

        // self::createMessage(1,1);
        

    }

    public function createAdmin()
    {
        $user = User::create([
            'id' => User_nan::database()->collection("users")->getModifySequence('id'),
            'admin' => 1,
            'sale' => 0,
            'name' => 'admin',
            'status' => 'offline',
            'image' => 'default.jpg',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$egUyhiia2q5ClKwVumGDS.dp7/1BNoD/pkVnSnDAWWdmWtHhYgh/K', //123456789
        ]);

    }

    public function createCategories($j)
    {
        $faker = Faker::create('App\Categorie');

        for ($i=0; $i <= $j ; $i++) { 
            
            $save = Categorie::database()->collection("categories")->insert([
                'id' => Categorie::database()->collection("categories")->getModifySequence('id'),
                'name' => $faker->sentence(),
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s")
            ]);

        }

    }

    public function createUsers($j)
    {
        $faker = Faker::create('App\User');

        for ($i=0; $i <= $j ; $i++) { 

            $user = User::create([
                'id' => User_nan::database()->collection("users")->getModifySequence('id'),
                'admin' => 0,
                'sale' => 0,
                'name' => $faker->name,
                'status' => 'offline',
                'image' =>  $faker->image('public/storage/user_images',400,300, null, false), 
                'email' => $faker->unique()->safeEmail,
                'password' => '$2y$10$egUyhiia2q5ClKwVumGDS.dp7/1BNoD/pkVnSnDAWWdmWtHhYgh/K', //123456789
                'remember_token' => Str::random(10),
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s")
            ]);
    
        }
    }

    public function createMessage($user_id1, $j)
    {
        $faker = Faker::create('App\Message');

        for ($i=0; $i <= $j ; $i++) { 

            $message_insert = Message::collection("messages")->insert(
                [
                    'id' => Message::database()->collection("messages")->getModifySequence('id'),
                    'user_id' => $user_id1,
                    'session' => 1,
                    'message' => $faker->text,
                    'status' => 1,
                    'created_at' =>  date("Y-m-d H:i:s"),
                    'updated_at' =>  date("Y-m-d H:i:s")
                ]);
    
        }
    }

}
