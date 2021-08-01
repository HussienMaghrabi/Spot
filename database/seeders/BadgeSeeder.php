<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('badges')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/badges/الغرفة_الثرية_برونزي.png',
            'gift_id' => '1',
            'badgeCategory_id' => '2',
            'category_id' => '1',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/badges/الغرفة_الثرية_فضي.png',
            'gift_id' => '1',
            'badgeCategory_id' => '2',
            'category_id' => '1',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'flower',
            'img_link' => 'uploads/badges/الغرفة_الثرية_ذهبي.png',
            'gift_id' => '1',
            'badgeCategory_id' => '2',
            'category_id' => '1',
            'amount' => '30',
        ]);
        DB::table('badges')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/badges/الغرفة_الساخنة_برونزي.png',
            'gift_id' => '2',
            'badgeCategory_id' => '2',
            'category_id' => '2',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/badges/الغرفة_الساخنة_الفضية.png',
            'gift_id' => '2',
            'badgeCategory_id' => '2',
            'category_id' => '2',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'kiss',
            'img_link' => 'uploads/badges/الغرفة_الساخنة_ذهبي.png',
            'gift_id' => '2',
            'badgeCategory_id' => '2',
            'category_id' => '2',
            'amount' => '30',
        ]);
        DB::table('badges')->insert([
            'name' => 'friends',
            'img_link' => 'uploads/badges/النجم_النشط_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '3',
        ]);
        DB::table('badges')->insert([
            'name' => 'friends',
            'img_link' => 'uploads/badges/النجم_النشط_الفضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '3',
        ]);
        DB::table('badges')->insert([
            'name' => 'friends',
            'img_link' => 'uploads/badges/النجم_النشط_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '3',
        ]);
        DB::table('badges')->insert([
            'name' => 'login',
            'img_link' => 'uploads/badges/مجنون_التسوق_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '1',
            'category_id' => '4',
        ]);
        DB::table('badges')->insert([
            'name' => 'login',
            'img_link' => 'uploads/badges/مجنون_التسوق_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '1',
            'category_id' => '4',
        ]);
        DB::table('badges')->insert([
            'name' => 'login',
            'img_link' => 'uploads/badges/مجنون_التسوق_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '1',
            'category_id' => '4',
        ]);
        DB::table('badges')->insert([
            'name' => 'level',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '5',
        ]);
        DB::table('badges')->insert([
            'name' => 'level',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '5',
        ]);
        DB::table('badges')->insert([
            'name' => 'level',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '5',
        ]);
    }
}
