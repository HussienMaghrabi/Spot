<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            levelsSeeder::class,
            karizmaSeeder::class,
            userSeeder::class,
            ItemSeeder::class,
            giftSeeder::class,
            BadgeSeeder::class,
            AdminSeeder::class,
            RoomSeeder::class,
            DailyGiftSeeder::class

        ]);
    }
}
