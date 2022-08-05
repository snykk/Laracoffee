<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            "bank_name" => "Mandiri",
            "account_number" => "092 7840 1923 7422",
            "logo" => "bank-mandiri.svg"
        ]);

        Bank::create([
            "bank_name" => "BRI",
            "account_number" => "082 9192 9183 3041",
            "logo" => "bank-bri.svg"
        ]);

        Bank::create([
            "bank_name" => "BCA",
            "account_number" => "019 8272 8274 1234",
            "logo" => "bank-bca.svg"
        ]);

        Bank::create([
            "bank_name" => "BNI",
            "account_number" => "076 8291 6371 6279",
            "logo" => "bank-bni.svg"
        ]);
    }
}
