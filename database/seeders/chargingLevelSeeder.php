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
        DB::table('charging_level')->insert([
            'user_id' => 1,
            'coins' => 500,
            'amount' => 100,
            'type' => 'valid_process',
        ]);
        DB::table('charging_level')->insert([
            'user_id' => 2,
            'coins' => 10000,
            'amount' => 1000,
            'type' => 'valid_process',
        ]);
        DB::table('charging_level')->insert([
            'user_id' => 3,
            'coins' => 5050,
            'amount' => 500,
            'type' => 'valid_process',
        ]);
        DB::table('charging_level')->insert([
            'user_id' => 1,
            'coins' => 500,
            'amount' => 100,
            'type' => 'valid_process',
        ]);
    }
}
