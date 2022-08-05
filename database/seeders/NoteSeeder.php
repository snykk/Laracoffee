<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Note::create([
            "order_notes" => "waiting for COD meeting"
        ]);

        Note::create([
            "order_notes" => "[no proof of transfer] is waiting for the proof of transaction to be sent"
        ]);

        Note::create([
            "order_notes" => "proof of transfer successfully sent, waiting for approval from admin"
        ]);

        Note::create([
            "order_notes" => "proof of transfer approved, waiting for product delivery"
        ]);

        Note::create([
            "order_notes" => "transaction success"
        ]);

        Note::create([
            "order_notes" => "the order is canceled directly by the user"
        ]);
    }
}
