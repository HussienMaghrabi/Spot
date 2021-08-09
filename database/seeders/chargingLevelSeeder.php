<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class chargingLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('charging_levels')->insert([
            'name' => '50 K',
            'level_limit' => 50000,
            'desc' => 'description',
            'badge_id' => '31',
            'levelNo' => '1',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '100 K',
            'level_limit' => 100000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '32',
            'levelNo' => '2',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '200 K',
            'level_limit' => 200000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '33',
            'levelNo' => '3',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '300 K',
            'level_limit' => 300000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '34',
            'levelNo' => '4',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '400 K',
            'level_limit' => 400000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '35',
            'levelNo' => '5',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '500 K',
            'level_limit' => 500000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '36',
            'levelNo' => '6',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '600 K',
            'level_limit' => 600000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '37',
            'levelNo' => '7',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '700 K',
            'level_limit' => 700000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '38',
            'levelNo' => '8',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '800 K',
            'level_limit' => 800000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '39',
            'levelNo' => '9',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '900 K',
            'level_limit' => 900000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '40',
            'levelNo' => '10',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '1 M',
            'level_limit' => 1000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '41',
            'levelNo' => '11',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '2 M',
            'level_limit' => 2000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '42',
            'levelNo' => '12',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '3 M',
            'level_limit' => 3000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '43',
            'levelNo' => '13',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '4 M',
            'level_limit' => 4000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '44',
            'levelNo' => '14',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '5 M',
            'level_limit' => 5000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '45',
            'levelNo' => '15',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '7 M',
            'level_limit' => 7000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '46',
            'levelNo' => '16',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '8 M',
            'level_limit' => 8000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '47',
            'levelNo' => '17',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '10 M',
            'level_limit' => 10000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '48',
            'levelNo' => '18',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '12 M',
            'level_limit' => 12000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '49',
            'levelNo' => '19',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '15 M',
            'level_limit' => 15000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '50',
            'levelNo' => '20',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '18 M',
            'level_limit' => 18000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '51',
            'levelNo' => '21',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '20 M',
            'level_limit' => 20000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '52',
            'levelNo' => '22',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '22 M',
            'level_limit' => 22000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '53',
            'levelNo' => '23',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '25 M',
            'level_limit' => 25000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '54',
            'levelNo' => '24',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '30 M',
            'level_limit' => 30000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '55',
            'levelNo' => '25',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '33 M',
            'level_limit' => 33000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '56',
            'levelNo' => '26',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '35 M',
            'level_limit' => 35000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '57',
            'levelNo' => '27',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '40 M',
            'level_limit' => 40000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '58',
            'levelNo' => '28',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '45 M',
            'level_limit' => 45000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '59',
            'levelNo' => '29',
        ]);
        DB::table('charging_levels')->insert([
            'name' => '50 M',
            'level_limit' => 50000000,
            'desc' => 'description',
            'gift_id' => '["1","2"]',
            'badge_id' => '60',
            'levelNo' => '30',
        ]);
    }
}
