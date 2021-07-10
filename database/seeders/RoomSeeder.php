<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('rooms')->insert([
            'name' => 'room1',
            'room_owner' => '1',
            'country_id' => '1',
            'category_id' => '1',
            'main_image' => 'uploads/rooms1/547Shunsui_and_Nanao_watch.png'
        ]);
        DB::table('rooms')->insert([
            'name' => 'room2',
            'room_owner' => '2',
            'country_id' => '2',
            'category_id' => '2',
            'main_image' => 'uploads/rooms1/547Shunsui_and_Nanao_watch.png'
        ]);
        DB::table('rooms')->insert([
            'name' => 'room3',
            'room_owner' => '3',
            'country_id' => '1',
            'category_id' => '1',
            'main_image' => 'uploads/rooms1/547Shunsui_and_Nanao_watch.png'

        ]);
        DB::table('rooms')->insert([
            'name' => 'room4',
            'room_owner' => '4',
            'country_id' => '2',
            'category_id' => '2',
            'main_image' => 'uploads/rooms1/547Shunsui_and_Nanao_watch.png'
        ]);
    }
}
