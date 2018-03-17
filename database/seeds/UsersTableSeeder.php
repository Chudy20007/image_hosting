<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();


        for ($i = 0; $i < 5; $i++)
        {
        $user = new User();
        $user ->name = $faker->name;
        $user->email = $faker->email;
        $user->is_active = 1;
        $user->is_admin = 1;
        $user->password = bcrypt('willock');

        $user2 = new User();
        $user2 ->name = $faker->name;
        $user2->email = $faker->email;
        $user2->is_active = 1;
        $user2->is_admin = 0;
        $user2->password = bcrypt('williams');

        $user3 = new User();
        $user3 ->name = $faker->name;
        $user3->email = $faker->email;
        $user3->is_active = 0;
        $user3->is_admin = 0;
        $user3->password = bcrypt('graham');
        
        $user->save();
        $user2->save();
        $user3->save();
        }

    }
}
