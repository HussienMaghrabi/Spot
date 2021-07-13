<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopSenderWeeklySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sender_top_weeklies')->insert([
            'user_id' => '2',
            'total' => '1496'
        ]);
        DB::table('sender_top_weeklies')->insert([
            'user_id' => '4',
            'total' => '965'
        ]);
        DB::table('sender_top_weeklies')->insert([
            'user_id' => '3',
            'total' => '788'
        ]);
        DB::table('sender_top_weeklies')->insert([
            'user_id' => '1',
            'total' => '758'
        ]);
    }
}
