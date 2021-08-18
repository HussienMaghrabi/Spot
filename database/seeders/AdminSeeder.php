<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Admin1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'api_token' => 'ZdP0jEjZ2BuipVoIxrQKmKGqEg9wJkEHBKFi2qGIZ4bdOkmaE2Cdx14kybBLGt34ITnu6Q'
        ]);

        DB::table('admins')->insert([
            'name' => 'Hussein El-Maghrabi',
            'email' => 'admin@admin.com',
            'super' => '1',
            'password' => Hash::make('123456'),
        ]);
    }
}
