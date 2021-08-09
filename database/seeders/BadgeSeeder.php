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
            'name' => 'الغرفة الثرية',
            'img_link' => 'uploads/badges/الغرفة_الثرية_برونزي.png',
            'gift_id' => '1',
            'badgeCategory_id' => '3',
            'category_id' => '1',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'الغرفة الثرية',
            'img_link' => 'uploads/badges/الغرفة_الثرية_فضي.png',
            'gift_id' => '1',
            'badgeCategory_id' => '3',
            'category_id' => '1',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'الغرفة الثرية',
            'img_link' => 'uploads/badges/الغرفة_الثرية_ذهبي.png',
            'gift_id' => '1',
            'badgeCategory_id' => '3',
            'category_id' => '1',
            'amount' => '30',
        ]);
        DB::table('badges')->insert([
            'name' => 'الغرفة الساخنة',
            'img_link' => 'uploads/badges/الغرفة_الساخنة_برونزي.png',
            'gift_id' => '2',
            'badgeCategory_id' => '3',
            'category_id' => '2',
            'amount' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'الغرفة الساخنة',
            'img_link' => 'uploads/badges/الغرفة_الساخنة_الفضية.png',
            'gift_id' => '2',
            'badgeCategory_id' => '3',
            'category_id' => '2',
            'amount' => '20',
        ]);
        DB::table('badges')->insert([
            'name' => 'الغرفة الساخنة',
            'img_link' => 'uploads/badges/الغرفة_الساخنة_ذهبي.png',
            'gift_id' => '2',
            'badgeCategory_id' => '3',
            'category_id' => '2',
            'amount' => '30',
        ]);
        DB::table('badges')->insert([
            'name' => 'النجم النشط',
            'img_link' => 'uploads/badges/النجم_النشط_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '3',
        ]);
        DB::table('badges')->insert([
            'name' => 'النجم النشط',
            'img_link' => 'uploads/badges/النجم_النشط_الفضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '3',
        ]);
        DB::table('badges')->insert([
            'name' => 'النجم النشط',
            'img_link' => 'uploads/badges/النجم_النشط_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '3',
        ]);
        DB::table('badges')->insert([
            'name' => 'مجنون التسوق',
            'img_link' => 'uploads/badges/مجنون_التسوق_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '4',
        ]);
        DB::table('badges')->insert([
            'name' => 'مجنون التسوق',
            'img_link' => 'uploads/badges/مجنون_التسوق_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '4',
        ]);
        DB::table('badges')->insert([
            'name' => 'مجنون التسوق',
            'img_link' => 'uploads/badges/مجنون_التسوق_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '4',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم حقيبة الحظ',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '5',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم حقيبة الحظ',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '5',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم حقيبة الحظ',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '5',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم محبوب',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '9',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم محبوب',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '9',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم محبوب',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '9',
        ]);
        DB::table('badges')->insert([
            'name' => 'مليونير',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '6',
        ]);
        DB::table('badges')->insert([
            'name' => 'مليونير',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '6',
        ]);
        DB::table('badges')->insert([
            'name' => 'مليونير',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '6',
        ]);
        DB::table('badges')->insert([
            'name' => 'نشط اجتماعي',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'نشط اجتماعي',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'نشط اجتماعي',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '10',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم لامع',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '8',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم لامع',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '8',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم لامع',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '8',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم تسجيل الدخول',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_برونزي.png',
            'amount' => '10',
            'badgeCategory_id' => '3',
            'category_id' => '7',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم تسجيل الدخول',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_فضي.png',
            'amount' => '20',
            'badgeCategory_id' => '3',
            'category_id' => '7',
        ]);
        DB::table('badges')->insert([
            'name' => 'نجم تسجيل الدخول',
            'img_link' => 'uploads/badges/نجم_حقيبة_الحظ_ذهبي.png',
            'amount' => '30',
            'badgeCategory_id' => '3',
            'category_id' => '7',
        ]);

        DB::table('badges')->insert([
            'name' => '50k',
            'img_link' => 'uploads/badges/50k.png',
            'amount' => '50000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '100k',
            'img_link' => 'uploads/badges/100k.png',
            'amount' => '100000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '200k',
            'img_link' => 'uploads/badges/200k.png',
            'amount' => '200000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '300k',
            'img_link' => 'uploads/badges/300k.png',
            'amount' => '300000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '400k',
            'img_link' => 'uploads/badges/400k.png',
            'amount' => '400000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '500k',
            'img_link' => 'uploads/badges/500k.png',
            'amount' => '500000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '600k',
            'img_link' => 'uploads/badges/600k.png',
            'amount' => '600000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '700k',
            'img_link' => 'uploads/badges/700k.png',
            'amount' => '700000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '800k',
            'img_link' => 'uploads/badges/800k.png',
            'amount' => '800000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '900k',
            'img_link' => 'uploads/badges/900k.png',
            'amount' => '900000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '1M',
            'img_link' => 'uploads/badges/1M.png',
            'amount' => '1000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '2M',
            'img_link' => 'uploads/badges/2M.png',
            'amount' => '2000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '3M',
            'img_link' => 'uploads/badges/3M.png',
            'amount' => '3000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '4M',
            'img_link' => 'uploads/badges/4M.png',
            'amount' => '4000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '5M',
            'img_link' => 'uploads/badges/5M.png',
            'amount' => '5000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '7M',
            'img_link' => 'uploads/badges/7M.png',
            'amount' => '7000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '8M',
            'img_link' => 'uploads/badges/8M.png',
            'amount' => '8000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '10M',
            'img_link' => 'uploads/badges/10M.png',
            'amount' => '10000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '12M',
            'img_link' => 'uploads/badges/12M.png',
            'amount' => '12000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '15M',
            'img_link' => 'uploads/badges/15M.png',
            'amount' => '15000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '18M',
            'img_link' => 'uploads/badges/18M.png',
            'amount' => '18000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '20M',
            'img_link' => 'uploads/badges/20M.png',
            'amount' => '20000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '22M',
            'img_link' => 'uploads/badges/22M.png',
            'amount' => '22000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '25M',
            'img_link' => 'uploads/badges/25M.png',
            'amount' => '25000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '30M',
            'img_link' => 'uploads/badges/30M.png',
            'amount' => '30000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '33M',
            'img_link' => 'uploads/badges/33M.png',
            'amount' => '33000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '35M',
            'img_link' => 'uploads/badges/35M.png',
            'amount' => '35000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '40M',
            'img_link' => 'uploads/badges/40M.png',
            'amount' => '40000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '45M',
            'img_link' => 'uploads/badges/45M.png',
            'amount' => '45000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
        DB::table('badges')->insert([
            'name' => '50M',
            'img_link' => 'uploads/badges/50M.png',
            'amount' => '50000000',
            'badgeCategory_id' => '3',
            'category_id' => '11',
            'charge_badge' => '1',
        ]);
    }
}
