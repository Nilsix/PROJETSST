<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "NilsAdmin",
            "email" => "na@na",
            "password" => bcrypt("testtest"),
            "vision" => 3,
            "numAgent" => "UR11720205"
        ]);
        User::create([
            "name" => "NilsGlobal",
            "email" => "ng@ng",
            "password" => bcrypt("testtest"),
            "vision" => 2,
            "numAgent" => "UR11717065"
        ]);
        User::create([
            "name" => "NilsLocale",
            "email" => "nl@nl",
            "password" => bcrypt("testtest"),
            "vision" => 1,
            "numAgent" => "UR11721356"
        ]);

        
    }
}
