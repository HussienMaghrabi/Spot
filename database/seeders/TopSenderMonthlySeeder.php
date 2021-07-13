<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopSenderMonthlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sender_top_monthlies')->insert([
            'user_id' => '3',
            'total' => '548'
        ]);
        DB::table('sender_top_monthlies')->insert([
            'user_id' => '4',
            'total' => '479'
        ]);
        DB::table('sender_top_monthlies')->insert([
            'user_id' => '2',
            'total' => '366'
        ]);
        DB::table('sender_top_monthlies')->insert([
            'user_id' => '1',
            'total' => '108'
        ]);
    }
}
