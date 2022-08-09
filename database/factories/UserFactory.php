<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $str_gender = "MF";
        return [
            'role_id' => 2,
            'fullname' => fake()->name(),
            'username' => fake()->firstName(),
            'email' => fake()->safeEmail(),
            'password' => Hash::make("1234"), // password,
            'image' => env("IMAGE_PROFILE"),
            'phone' => fake()->phoneNumber(),
            'gender' => $str_gender[rand(0, 1)],
            'address' => fake()->address(),
            'role_id' => 2,
            'coupon' => 0,
            'point' => 0,
            'remember_token' => Str::random(30),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
