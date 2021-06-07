<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'api_token' => 'VVnTLpWxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'verify' => '1'
        ]);

        DB::table('users')->insert([
            'name' => 'User2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'api_token' => 'VVnTpWxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'verify' => '1'
        ]);

        DB::table('users')->insert([
            'name' => 'User3',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'api_token' => 'VVnTLWxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'verify' => '1'
        ]);

        DB::table('users')->insert([
            'name' => 'User4',
            'email' => 'user4@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users/tux0RCdSoCQ4ALHuVAarpGtxUu7TGlUCVrG2MKLG.png',
            'api_token' => 'VVnTLpxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'verify' => '1'
        ]);

    }
}
