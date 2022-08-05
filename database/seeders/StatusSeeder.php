<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            "order_status" => "approve",
            "style" => "success",
        ]);

        Status::create([
            "order_status" => "pending",
            "style" => "warning",
        ]);

        Status::create([
            "order_status" => "rejected",
            "style" => "danger",
        ]);

        Status::create([
            "order_status" => "done",
            "style" => "info",
        ]);

        Status::create([
            "order_status" => "canceled",
            "style" => "secondary",
        ]);
    }
}
