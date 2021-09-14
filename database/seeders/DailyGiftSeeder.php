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
            'image_link' => 'uploads/items/png3.png',
            'gift_id' => '1',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day2',
            'image_link' => 'uploads/coins.png',
            'coins' => '3',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day3',
            'image_link' => 'uploads/coins.png',
            'coins' => '10',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day4',
            'image_link' => 'uploads/items/png5.png',
            'gift_id' => '3',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day5',
            'image_link' => 'uploads/items/market-1.png',
            'item_id' => '1',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day6',
            'image_link' => 'uploads/items/market-4.png',
            'item_id' => '4',
        ]);
        DB::table('daily_gift')->insert([
            'name' => 'day7',
            'image_link' => 'uploads/coins.png',
            'coins' => '50',
        ]);
    }
}
