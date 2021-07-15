<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class messageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 2,
            'message' => 'hi from me'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 3,
            'message' => 'hi from me'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 4,
            'message' => 'hi from me'
        ]);
        DB::table('messages')->insert([
            'user_from' => 4,
            'user_to' => 2,
            'message' => 'hi from me'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 3,
            'message' => 'other message'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 3,
            'message' => '3aml eh'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 3,
            'message' => 'hi no 3'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 3,
            'message' => 'oooas'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 4,
            'message' => 'hey no 4'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 2,
            'message' => 'assf3'
        ]);
        DB::table('messages')->insert([
            'user_from' => 1,
            'user_to' => 2,
            'message' => 'hey 22'
        ]);
    }
}
