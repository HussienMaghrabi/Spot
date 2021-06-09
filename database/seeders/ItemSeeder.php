<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('items')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '50',
            'duration' => '10',
            'type' => '1'
        ]);

        DB::table('items')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '10',
            'duration' => '20',
            'type' => '1'
        ]);
        DB::table('items')->insert([
            'name' => 'car',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '50',
            'duration' => '30',
            'type' => '2'
        ]);

        DB::table('items')->insert([
            'name' => 'tower',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '10',
            'duration' => '40',
            'type' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'dragon',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '50',
            'duration' => '50',
            'type' => '3'
        ]);

        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '10',
            'duration' => '60',
            'type' => '3'
        ]);
    }
}
