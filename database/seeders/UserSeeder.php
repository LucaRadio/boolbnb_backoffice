<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->name = $faker->firstName();
            $user->surname = $faker->lastName();
            $user->email = $faker->email();
            $user->date_of_birth = $faker->date();
            $user->password = 'password';
            $user->save();
        }
    }
}
