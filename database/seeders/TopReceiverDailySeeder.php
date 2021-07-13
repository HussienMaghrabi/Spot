<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopReceiverDailySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receiver_top_dailies')->insert([
            'user_id' => '2',
            'total' => '96'
        ]);
        DB::table('receiver_top_dailies')->insert([
            'user_id' => '4',
            'total' => '65'
        ]);
        DB::table('receiver_top_dailies')->insert([
            'user_id' => '3',
            'total' => '48'
        ]);
        DB::table('receiver_top_dailies')->insert([
            'user_id' => '1',
            'total' => '28'
        ]);
    }
}
