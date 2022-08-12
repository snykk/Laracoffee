<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "category_name" => "Product Sale",
        ]);

        Category::create([
            "category_name" => "Production Cost",
        ]);

        Category::create([
            "category_name" => "Marketing Cost",
        ]);

        Category::create([
            "category_name" => "Server Maintanance",
        ]);
    }
}
