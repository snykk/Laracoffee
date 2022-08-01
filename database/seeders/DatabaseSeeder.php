<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            "fullname" => "Moh. Najib Fikri",
            "username" => "pStar7",
            "email" => "najibfikri13@gmail.com",
            "password" => Hash::make("1234"),
            "image" => env("DEFAULT_IMAGE_PROFILE"),
            "phone" => "08123456789123",
            "gender" => "M",
            "address" => "Shell road number 10",
            "role_id" => "1",
            'remember_token' => Str::random(30),
        ]);

        User::create([
            "fullname" => "Patrick Star",
            "username" => "its_me",
            "email" => "member@gmail.com",
            "password" => Hash::make("1234"),
            "image" => env("DEFAULT_IMAGE_PROFILE"),
            "phone" => "082918391823",
            "gender" => "M",
            "address" => "Shell road number 18",
            "role_id" => "2",
            'remember_token' => Str::random(30),
        ]);

        User::factory(5)->create();

        Role::create([
            "id" => 1,
            "role_name" => "Admin"
        ]);

        Role::create([
            "id" => 2,
            "role_name" => "Customer"
        ]);
    }
}
