<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopReceiverMonthlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receiver_top_monthlies')->insert([
            'user_id' => '1',
            'total' => '2496'
        ]);
        DB::table('receiver_top_monthlies')->insert([
            'user_id' => '3',
            'total' => '2265'
        ]);
        DB::table('receiver_top_monthlies')->insert([
            'user_id' => '2',
            'total' => '1948'
        ]);
        DB::table('receiver_top_monthlies')->insert([
            'user_id' => '4',
            'total' => '1728'
        ]);
    }
}
