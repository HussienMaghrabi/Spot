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
            CountriesSeeder::class,
            CategoriesSeeder::class,
            levelsSeeder::class,
            karizmaSeeder::class,
            VipSeeder::class,
            userSeeder::class,
            ItemSeeder::class,
            giftSeeder::class,
            BadgeSeeder::class,
            AdminSeeder::class,
            RoomSeeder::class,
            DailyGiftSeeder::class,
            diamondSeeder::class,
            RoomMembersSeeder::class,
            chargingLevelSeeder::class,
            InquiryCatSeeder::class,
            InquirySeeder::class,
            userChargingLevelSeeder::class,
            messageSeeder::class,
            FriedRequestsSeeder::class,
            TopSenderWeeklySeeder::class,
            TopSenderMonthlySeeder::class,
            TopSenderDailySeeder::class,
            TopReceiverWeeklySeeder::class,
            TopReceiverMonthlySeeder::class,
            TopReceiverDailySeeder::class,
            FollowRelationSeeder::class,
        ]);
    }
}
