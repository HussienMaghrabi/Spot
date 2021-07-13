<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userChargingLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_charging_level')->insert([
            'user_id' => 1,
            'earning' => 0,
            'coins' => 0,
            'user_level' => 0
        ]);
        DB::table('user_charging_level')->insert([
            'user_id' => 2,
            'earning' => 8000,
            'coins' => 0,
            'user_level' => 2
        ]);
        DB::table('user_charging_level')->insert([
            'user_id' => 3,
            'earning' => 3000,
            'coins' => 500,
            'user_level' => 1
        ]);
    }
}
