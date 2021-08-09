<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('badge_parents')->insert([
            'name' => 'الغرفة الثرية',
            'image' => 'uploads/badges/الغرفة_الثرية_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'الغرفة الساخنة',
            'image' => 'uploads/badges/الغرفة_الساخنة_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'النجم النشط',
            'image' => 'uploads/badges/النجم_النشط_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'مجنون التسوق',
            'image' => 'uploads/badges/مجنون_التسوق_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'نجم حقيبة الحظ',
            'image' => 'uploads/badges/نجم_حقيبة_الحظ_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'مليونير',
            'image' => 'uploads/badges/مليونير_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'نجم تسجيل الدخول',
            'image' => 'uploads/badges/نجم_تسجيل_الدخول_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'نجم لامع',
            'image' => 'uploads/badges/نجم_لامع_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'نجم محبوب',
            'image' => 'uploads/badges/نجم_محبوب_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'نشط اجتماعي',
            'image' => 'uploads/badges/نشط_اجتماعي_برونزي.png',
            'badge_categoryId' => '3',
        ]);
        DB::table('badge_parents')->insert([
            'name' => 'charge',
            'image' => 'uploads/badges/50k.png',
            'badge_categoryId' => '3',
            'charge_badge' => '1',
        ]);
    }
}
