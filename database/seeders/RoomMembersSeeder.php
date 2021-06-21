<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_members')->insert([
            'room_id' => '1',
            'follow_user' => '["1", "3"]',
            'join_user' => '["1", "2", "3"]'
        ]);
        DB::table('room_members')->insert([
            'room_id' => '2',
            'follow_user' => '["4", "3"]',
            'join_user' => '["1", "4", "3"]'
        ]);
        DB::table('room_members')->insert([
            'room_id' => '3',
            'follow_user' => '["4", "2"]',
            'join_user' => '["1", "2", "4"]'
        ]);
        DB::table('room_members')->insert([
            'room_id' => '4',
            'follow_user' => '["1", "2"]',
            'join_user' => '["4", "2", "3"]'
        ]);
    }
}
