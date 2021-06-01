<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class giftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('gifts')->insert([
            'name' => 'flower',
            'img_link' => Str::random(10),
            'price' => '50',
        ]);

        DB::table('gifts')->insert([
            'name' => 'kiss',
            'img_link' => Str::random(10),
            'price' => '10',
        ]);
    }
}
