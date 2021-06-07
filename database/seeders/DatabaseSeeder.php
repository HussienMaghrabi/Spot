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
<<<<<<< HEAD
            userSeeder::class,
            ItemSeeder::class,
            giftSeeder::class,
            BadgeSeeder::class,
            AdminSeeder::class,
            RoomSeeder::class,
            DailyGiftSeeder::class
=======
            diamondSeeder::class,
>>>>>>> f8e8a8aff8e211ad32980d2bcf893eaac6c36f43

        ]);
    }
}
