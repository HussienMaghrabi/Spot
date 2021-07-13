<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopReceiverWeeklySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receiver_top_weeklies')->insert([
            'user_id' => '1',
            'total' => '896'
        ]);
        DB::table('receiver_top_weeklies')->insert([
            'user_id' => '3',
            'total' => '765'
        ]);
        DB::table('receiver_top_weeklies')->insert([
            'user_id' => '2',
            'total' => '648'
        ]);
        DB::table('receiver_top_weeklies')->insert([
            'user_id' => '4',
            'total' => '528'
        ]);
    }
}
