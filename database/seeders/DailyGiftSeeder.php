<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DailyGiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('daily_gift')->insert([
            'name' => 'day1',
            'image_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'gift_id' => '1',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day2',
            'image_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'coins' => '3',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day3',
            'image_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'coins' => '10',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day4',
            'image_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'gift_id' => '3',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day5',
            'image_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'item_id' => '1',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day6',
            'image_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'item_id' => '4',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day7',
            'image_link' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'coins' => '50',
        ]);
    }
}
