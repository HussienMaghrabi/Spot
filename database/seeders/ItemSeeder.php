<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('items')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/items/item1.jpeg',
            'file' => 'uploads/items/angel.svga',
            'price' => '50',
            'duration' => '10',
            'type' => '1',
            'cat_id' => '1'
        ]);

        DB::table('items')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/items/item2.jpeg',
            'file' => 'uploads/items/EmptyState.svga',
            'price' => '10',
            'duration' => '20',
            'type' => '1',
            'cat_id' => '1'
        ]);
        DB::table('items')->insert([
            'name' => 'car',
            'img_link' => 'uploads/items/item3.jpeg',
            'file' => 'uploads/items/halloween.svga',
            'price' => '50',
            'duration' => '30',
            'type' => '2',
            'cat_id' => '2'
        ]);

        DB::table('items')->insert([
            'name' => 'tower',
            'img_link' => 'uploads/items/item4.jpeg',
            'file' => 'uploads/items/heartbeat.svga',
            'price' => '10',
            'duration' => '40',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'dragon',
            'img_link' => 'uploads/items/item5.jpeg',
            'file' => 'uploads/items/kingset.svga',
            'price' => '50',
            'duration' => '50',
            'type' => '3',
            'cat_id' => '3'
        ]);

        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/item6.jpeg',
            'file' => 'uploads/items/Rocket.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '3',
            'cat_id' => '3'
        ]);

        DB::table('items')->insert([
            'name' => 'mic_border7',
            'img_link' => 'uploads/items/item1.jpeg',
            'file' => 'uploads/items/rose.svga',
            'price' => '0',
            'duration' => '60',
            'vip_item' => '6',
            'type' => '1'
        ]);

        DB::table('items')->insert([
            'name' => 'chat_bubble7',
            'img_link' => 'uploads/items/item2.jpeg',
            'file' => 'uploads/items/TwitterHeart.svga',
            'price' => '0',
            'duration' => '60',
            'vip_item' => '6',
            'type' => '4'
        ]);

        DB::table('items')->insert([
            'name' => 'mic_border6',
            'img_link' => 'uploads/items/item3.jpeg',
            'file' => 'uploads/items/TwitterHeart.svga',
            'price' => '0',
            'duration' => '60',
            'vip_item' => '5',
            'type' => '1'
        ]);

        DB::table('items')->insert([
            'name' => 'chat_bubble6',
            'img_link' => 'uploads/items/item4.jpeg',
            'file' => 'uploads/items/TwitterHeart.svga',
            'price' => '0',
            'duration' => '60',
            'vip_item' => '5',
            'type' => '4'
        ]);
    }
}
