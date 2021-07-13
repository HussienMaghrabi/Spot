<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FriedRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('friend_relations')->insert([
            'user_1' => '4',
            'user_2' => '1',
            'is_added' => '0'
        ]);
        DB::table('friend_relations')->insert([
            'user_1' => '3',
            'user_2' => '1',
            'is_added' => '0'
        ]);
        DB::table('friend_relations')->insert([
            'user_1' => '3',
            'user_2' => '1',
            'is_added' => '0'
        ]);
        DB::table('friend_relations')->insert([
            'user_1' => '3',
            'user_2' => '2',
            'is_added' => '0'
        ]);
        DB::table('friend_relations')->insert([
            'user_1' => '3',
            'user_2' => '4',
            'is_added' => '0'
        ]);
        DB::table('friend_relations')->insert([
            'user_1' => '4',
            'user_2' => '2',
            'is_added' => '0'
        ]);
    }
}
