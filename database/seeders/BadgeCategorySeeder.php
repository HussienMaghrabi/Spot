<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('badges_categories')->insert([
            'name_ar' => 'Activity ar',
            'name_en' => 'Activity',
        ]);
        DB::table('badges_categories')->insert([
            'name_ar' => 'Gifts ar',
            'name_en' => 'Gifts',
        ]);
        DB::table('badges_categories')->insert([
            'name_ar' => 'Achievements ar',
            'name_en' => 'Achievements',
        ]);
    }
}
