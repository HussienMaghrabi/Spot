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
            'img_link' => 'uploads/items/market-1.png',
            'file' => 'uploads/items/market-1.svga',
            'price' => '50',
            'duration' => '10',
            'type' => '3',
            'cat_id' => '3'
        ]);
        DB::table('items')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/items/market-2.png',
            'file' => 'uploads/items/market-2.svga',
            'price' => '10',
            'duration' => '20',
            'type' => '3',
            'cat_id' => '3'
        ]);
        DB::table('items')->insert([
            'name' => 'car',
            'img_link' => 'uploads/items/market-3.png',
            'file' => 'uploads/items/market-3.svga',
            'price' => '50',
            'duration' => '30',
            'type' => '3',
            'cat_id' => '3'
        ]);
        DB::table('items')->insert([
            'name' => 'tower',
            'img_link' => 'uploads/items/market-4.png',
            'file' => 'uploads/items/market-4.svga',
            'price' => '10',
            'duration' => '40',
            'type' => '3',
            'cat_id' => '3'
        ]);
        DB::table('items')->insert([
            'name' => 'dragon',
            'img_link' => 'uploads/items/market-5.png',
            'file' => 'uploads/items/market-5.svga',
            'price' => '50',
            'duration' => '50',
            'type' => '3',
            'cat_id' => '3'
        ]);

        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame2.png',
            'file' => 'uploads/items/Frame2.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame3.png',
            'file' => 'uploads/items/Frame3.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame4(-weekly-gift-star-).png',
            'file' => 'uploads/items/Frame4(-weekly-gift-star-).svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame5.png',
            'file' => 'uploads/items/Frame5.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame6(-the-beloved-).png',
            'file' => 'uploads/items/Frame6(-the-beloved-).svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame7.png',
            'file' => 'uploads/items/Frame7.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame8.png',
            'file' => 'uploads/items/Frame8.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame9.png',
            'file' => 'uploads/items/Frame9.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame10.png',
            'file' => 'uploads/items/Frame10.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
        DB::table('items')->insert([
            'name' => 'ball',
            'img_link' => 'uploads/items/Frame11.png',
            'file' => 'uploads/items/Frame11.svga',
            'price' => '10',
            'duration' => '60',
            'type' => '2',
            'cat_id' => '2'
        ]);
    }
}
