<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InquiryCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inquiry_categories')->insert([
            'name' => 'App problem'
        ]);
        DB::table('inquiry_categories')->insert([
            'name' => 'Suggestions'
        ]);
        DB::table('inquiry_categories')->insert([
            'name' => 'Balance'
        ]);
        DB::table('inquiry_categories')->insert([
            'name' => 'Others'
        ]);
    }
}
