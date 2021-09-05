<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DailyExpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('daily_limit_exps')->insert([
        'mic_exp_max' => 180,
        'mic_exp_val' => 3,
        'follow_exp_max' => 20,
        'follow_exp_val' => 2,
        'gift_send_max' => 500,
        'gift_receive_max' => 500,
        'login_max' => 20,
        'charge_val' => 50,
        'gift_val' => 30,
        ]);
    }
}
