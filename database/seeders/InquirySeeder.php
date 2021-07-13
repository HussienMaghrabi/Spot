<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inquiries')->insert([
            'inq_cat' => '1',
            'user_id' => '1',
            'desc' => 'test test test',
            'problem_img' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png'
        ]);
        DB::table('inquiries')->insert([
            'inq_cat' => '2',
            'user_id' => '2',
            'desc' => 'test test test',
            'problem_img' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png'
        ]);
        DB::table('inquiries')->insert([
            'inq_cat' => '3',
            'user_id' => '3',
            'desc' => 'test test test',
            'problem_img' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png'
        ]);
    }
}
