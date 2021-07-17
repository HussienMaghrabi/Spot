<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_categories')->insert([
            'name_ar' => 'موضوعات',
            'name_en' => 'backgrounds',
        ]);

        DB::table('item_categories')->insert([
            'name_ar' => 'إطار المايك',
            'name_en' => 'mic borders',
        ]);

        DB::table('item_categories')->insert([
            'name_ar' => 'مركبات',
            'name_en' => 'vehicle',
        ]);
    }
}
