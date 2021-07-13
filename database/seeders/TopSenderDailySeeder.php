<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopSenderDailySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sender_top_dailies')->insert([
            'user_id' => '1',
            'total' => '120'
        ]);
        DB::table('sender_top_dailies')->insert([
            'user_id' => '4',
            'total' => '87'
        ]);
        DB::table('sender_top_dailies')->insert([
            'user_id' => '2',
            'total' => '45'
        ]);
        DB::table('sender_top_dailies')->insert([
            'user_id' => '3',
            'total' => '20'
        ]);
    }
}
