<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class chargingLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('charging_levels')->insert([
            'name' => '50 K',
            'level_limit' => 50000,
            'gift_id' => '["1","2"]',
            'badge_id' => '1',
            'levelNo' => '1',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '100 K',
            'level_limit' => 100000,
            'gift_id' => '["1","2"]',
            'badge_id' => '2',
            'levelNo' => '2',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '200 K',
            'level_limit' => 200000,
            'gift_id' => '["1","2"]',
            'badge_id' => '3',
            'levelNo' => '3',
        ]);
    }
}
