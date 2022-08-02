<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
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

        for ($i = 1; $i <= 6; $i++) {
            Product::create([
                "product_name" => "Product $i",
                "orientation" => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Adipisci porro debitis eius deserunt odio, repudiandae ad repellendus laboriosam nobis sed?",
                "description" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatem temporibus, pariatur, tempore quia officiis at repudiandae dolore assumenda sunt fugiat alias illo nam minus autem dolor voluptate. Dignissimos eum natus ipsum optio neque numquam, voluptatem autem! Officiis, voluptas. Dolorum atque minima, aliquam facilis minus exercitationem aliquid doloremque vero, error qui consequatur quas tempore aspernatur asperiores cupiditate similique? Eius esse excepturi repellat deleniti, asperiores quas magni! Labore facere dicta expedita natus quisquam eaque, aspernatur minima quas nobis mollitia soluta sed id incidunt consequatur recusandae. Asperiores distinctio cum recusandae, odit earum quod vero similique assumenda? Autem perferendis ipsa accusamus id eaque. Sapiente!",
                "price" => rand(5000, 30000),
                "stock" => rand(10, 100),
                "discount" => 0.05,
                "image" => env("DEFAULT_IMAGE_PRODUCT"),
            ]);
        }
    }
}
