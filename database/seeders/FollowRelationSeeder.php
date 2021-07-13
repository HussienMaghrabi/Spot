<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('follow_relations')->insert([
            'user_1' => '4',
            'user_2' => '1',
        ]);
        DB::table('follow_relations')->insert([
            'user_1' => '1',
            'user_2' => '4',
        ]);
        DB::table('follow_relations')->insert([
            'user_1' => '4',
            'user_2' => '2',
        ]);
        DB::table('follow_relations')->insert([
            'user_1' => '4',
            'user_2' => '3',
        ]);
        DB::table('follow_relations')->insert([
            'user_1' => '3',
            'user_2' => '1',
        ]);
        DB::table('follow_relations')->insert([
            'user_1' => '2',
            'user_2' => '1',
        ]);
    }
}
