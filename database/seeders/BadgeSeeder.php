<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('badges')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'gift_id' => '1',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'gift_id' => '1',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'gift_id' => '1',
            'amount' => '30',
        ]);
        DB::table('badges')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'gift_id' => '2',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'gift_id' => '2',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'gift_id' => '2',
            'amount' => '30',
        ]);
        DB::table('badges')->insert([
            'name' => 'friends',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'friends',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'friends',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '30',
        ]);
        DB::table('badges')->insert([
            'name' => 'login',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'login',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'login',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '30',
        ]);
        DB::table('badges')->insert([
            'name' => 'level',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'level',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'level',
            'img_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'amount' => '30',
        ]);
    }
}
