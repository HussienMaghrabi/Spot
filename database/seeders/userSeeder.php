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
            'special_id' => Str::random(9),
            'name' => 'User1',
            'coins' => '1000',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users1/خلفيات-بنات-9-1.jpg',
            'api_token' => 'VVnTLpWxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'country_id' => '1',
            'gender' => 'Male',
            'vip_role' => '1',
            'verify' => '1'
        ]);

        DB::table('users')->insert([
            'special_id' => Str::random(9),
            'name' => 'User2',
            'coins' => '1000',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users2/pp.jpg',
            'api_token' => 'VVnTpWxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'vip_role' => '2',
            'country_id' => '2',
            'gender' => 'Male',
            'verify' => '1'
        ]);

        DB::table('users')->insert([
            'special_id' => Str::random(9),
            'name' => 'User3',
            'coins' => '1000',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users3/1231.jpg',
            'api_token' => 'VVnTLWxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'vip_role' => '3',
            'country_id' => '3',
            'gender' => 'Male',
            'verify' => '1'
        ]);

        DB::table('users')->insert([
            'special_id' => Str::random(9),
            'name' => 'User4',
            'coins' => '1000',
            'email' => 'user4@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users4/152364.jpg',
            'api_token' => 'VVnTLpxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'vip_role' => '6',
            'country_id' => '1',
            'gender' => 'Male',
            'verify' => '1'
        ]);

        DB::table('users')->insert([
            'special_id' => Str::random(9),
            'name' => 'User5',
            'coins' => '1000',
            'email' => 'user5@gmail.com',
            'password' => Hash::make('password'),
            'profile_pic' => 'uploads/users5/9pm0Ovrn4ZmAaQMrulXRE5SzUqvJxn5ld8wmScCj.jpg',
            'api_token' => 'VVnTLrxUI73ejfD5GKYbOeiF5mmuShHjAUa7dme9Nbq3efemztR081LaaTZVQC7gGWXm4',
            'country_id' => '1',
            'gender' => 'Male',
            'verify' => '1'
        ]);

    }
}
