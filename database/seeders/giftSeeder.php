<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class giftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('gifts')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '50',
        ]);

        DB::table('gifts')->insert([
            'name' => 'kisHits',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '10',
        ]);
        DB::table('gifts')->insert([
            'name' => 'car',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '50',
        ]);

        DB::table('gifts')->insert([
            'name' => 'tower',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '10',
        ]);
        DB::table('gifts')->insert([
            'name' => 'dragon',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '50',
        ]);

        DB::table('gifts')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '10',
        ]);

        DB::table('gifts')->insert([
            'name' => 'vip7_gift',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'price' => '299',
        ]);
    }
}
