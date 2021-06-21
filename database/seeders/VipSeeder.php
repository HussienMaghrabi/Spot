<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vip_tiers')->insert([
            'name' => 'Vip1',
            'price' => '100',
            'renew_price' => '98',
            'privileges' => '["1", "2", "3"]'
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip2',
            'price' => '300',
            'renew_price' => '295',
            'privileges' => '["1", "2", "3"]'
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip3',
            'price' => '500',
            'renew_price' => '495',
            'privileges' => '["room-password", "2", "3"]'
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip4',
            'price' => '800',
            'renew_price' => '790',
            'privileges' => '["room-password", "2", "3"]'
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip5',
            'price' => '1000',
            'renew_price' => '990',
            'privileges' => '["room-password", "2", "3"]'
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip6',
            'price' => '2000',
            'renew_price' => '1980',
            'privileges' => '["room-password", "2", "3"]'
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip7',
            'price' => '3000',
            'renew_price' => '2970',
            'privileges' => '["room-password", "2", "3"]'
        ]);
    }
}
