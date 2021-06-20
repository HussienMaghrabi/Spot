<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contries')->insert([
            'name' => 'UAE',
        ]);
        DB::table('contries')->insert([
            'name' => 'EGY',
        ]);
        DB::table('contries')->insert([
            'name' => 'KSA',
        ]);
    }
}
