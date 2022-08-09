<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "fullname" => "Moh. Najib Fikri",
            "username" => "pStar7",
            "email" => "najibfikri13@gmail.com",
            "password" => Hash::make("1234"),
            "image" => env("IMAGE_PROFILE"),
            "phone" => "08123456789123",
            "gender" => "M",
            "address" => "Shell road number 10",
            "role_id" => 1,
            "coupon" => 0,
            "point" => 0,
            'remember_token' => Str::random(30),
        ]);

        User::create([
            "fullname" => "Patrick Star",
            "username" => "its_me",
            "email" => "member@gmail.com",
            "password" => Hash::make("1234"),
            "image" => env("IMAGE_PROFILE"),
            "phone" => "082918391823",
            "gender" => "M",
            "address" => "Shell road number 18",
            "role_id" => 2,
            "coupon" => 0,
            "point" => 0,
            'remember_token' => Str::random(30),
        ]);

        User::create([
            "fullname" => "Squidy",
            "username" => "goodman",
            "email" => "squidy@gmail.com",
            "password" => Hash::make("1234"),
            "image" => env("IMAGE_PROFILE"),
            "phone" => "019292823382",
            "gender" => "M",
            "address" => "Small healt",
            "role_id" => 2,
            "coupon" => 0,
            "point" => 0,
            'remember_token' => Str::random(30),
        ]);

        User::factory(5)->create();
    }
}
