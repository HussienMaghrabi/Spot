<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class diamondSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diamonds')->insert(['req_diamond' => '100', 'coins' => '98']);
        DB::table('diamonds')->insert(['req_diamond' => '300', 'coins' => '295']);
        DB::table('diamonds')->insert(['req_diamond' => '800', 'coins' => '790']);
        DB::table('diamonds')->insert(['req_diamond' => '1000', 'coins' => '990']);
        DB::table('diamonds')->insert(['req_diamond' => '2000', 'coins' => '1980']);
        DB::table('diamonds')->insert(['req_diamond' => '3000', 'coins' => '2970']);
    }
}
