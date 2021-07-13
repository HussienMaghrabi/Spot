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
            'name' => 'المستوي الاول',
            'level_limit' => 1000,
            'levelNo' => 1,
        ]);
        DB::table('charging_level')->insert([
            'name' => 'المستوي الثاني',
            'level_limit' => 5000,
            'levelNo' => 2,
        ]);
        DB::table('charging_level')->insert([
            'name' => 'المستوي الثالث',
            'level_limit' => 10000,
            'levelNo' => 3,
        ]);
    }
}
