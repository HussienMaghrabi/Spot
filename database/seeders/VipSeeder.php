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
    // public function privileges()
    // {
    //     return [
    //             "vip_logo" => 1,
    //             "vip_mic_border" => 1,
    //             "commetion_gift" => 1,
    //             "commetion_gift_value" => 2.5,
    //             "login_effect" => 1,
    //             "colored_name" => 1,
    //             "topLevel" =>1,
    //             "color_name" => "red",
    //             "special_gift" => 1,
    //             "special_gift_id" => 1,
    //             "arsto_card" => 1,
    //             "arsto_card_id" => 1,
    //     ];
    // }
    public function run()
    {
        DB::table('vip_tiers')->insert([
            'name' => 'Vip1',
            'price' => '7000',
            'renew_price' => '5250',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_logo_value" => 1,
                    "vip_logo_desc_ar" => 1, // logo
                    "vip_logo_desc_en" => 1, // logo
                    "vip_mic_border" => 1,
                    "vip_mic_border_value" => 1,
                    "vip_mic_border_desc_ar" => 1, // mic border
                    "vip_mic_border_desc_en" => 1, // mic border
                    "topLevel" =>1,
                    "topLevel_value" =>1,
                    "topLevel_desc_ar" =>1, // toplevel
                    "topLevel_desc_en" =>1, // toplevel
                    "commission_gift" => 1,
                    "commission_gift_value" => 2.5,
                    "commission_gift_desc_ar" => 2.5, // gift commission from room
                    "commission_gift_desc_en" => 2.5, // gift commission from room
                    "entrance_effect" => 1,
                    "entrance_effect_value" => 1,
                    "entrance_effect_desc_ar" => 1, // entrance effect
                    "entrance_effect_desc_en" => 1, // entrance effect
                    "colored_name" => 1,
                    "colored_name_value" => 1,
                    "colored_name_desc_ar" => 1, // colored_name
                    "colored_name_desc_en" => 1, // colored_name
                    "special_gift" => 1,
                    "special_gift_value" => 0,
                    "special_gift_count" => 0,
                    "special_gift_desc_ar" => 0, // special gift
                    "special_gift_desc_en" => 0, // special gift
                    "arsto_card" => 1,
                    "arsto_card_value" => 1,
                    "arsto_card_desc_ar" => "1", // arsto card desc
                    "arsto_card_desc_en" => "1", // arsto card desc
                    "vip_vehicle" => 0,
                    "vip_vehicle_value" => 0,
                    "vip_vehicle_desc_ar" => "", // vehicle
                    "vip_vehicle_desc_en" => "", // vehicle
                    "colored_messages" => 0,
                    "colored_messages_value" => 0,
                    "colored_messages_desc_ar" => "", // colored_message
                    "colored_messages_desc_en" => "", // colored_message
                    "room_password"=> 0,
                    "room_password_value"=> 0,
                    "room_password_desc_ar"=> "", // room password
                    "room_password_desc_en"=> "", // room password
                    "anti-kick" => 0,
                    "anti-kick_value" => 0,
                    "anti-kick_desc_ar" => "", // anti kick
                    "anti-kick_desc_en" => "", // anti kick
                    "hide_country" => 0,
                    "hide_country_value" => 0,
                    "hide_country_desc_ar" => "", // hide country
                    "hide_country_desc_en" => "", // hide country
                    "anti-ban-chat"=> 0,
                    "anti-ban-chat_value"=> 0,
                    "anti-ban-chat_desc_ar"=> "", // ban chat
                    "anti-ban-chat_desc_en"=> "", // ban chat
                    "exp" => 0,
                    "exp_value" => 0,
                    "exp_value_desc_ar" => "", // exp % gain
                    "exp_value_desc_en" => "", // exp % gain
                    "support_first" => 0,
                    "support_value" => 0,
                    "support_desc_ar" => "",  // support desc
                    "support_desc_en" => "",  // support desc
                    "upload_background" => 0,
                    "upload_background_value" => 0,
                    "upload_background_desc_ar" => "", // upload background desc
                    "upload_background_desc_en" => "", // upload background desc
                    "daily_login_reward" => 1,
                    "daily_login_reward_value" => 200,
                    "daily_login_reward_desc_ar" => "",
                    "daily_login_reward_desc_en" => "",
                ]
            )
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip2',
            'price' => '20000',
            'renew_price' => '15000',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_logo_value" => 1,
                    "vip_logo_desc_ar" => "", // logo
                    "vip_logo_desc_en" => "", // logo
                    "vip_mic_border" => 1,
                    "vip_mic_border_value" => 1,
                    "vip_mic_border_desc_ar" => "", // mic border
                    "vip_mic_border_desc_en" => "", // mic border
                    "topLevel" =>1,
                    "topLevel_value" =>1,
                    "topLevel_desc_ar" =>"", // toplevel
                    "topLevel_desc_en" =>"", // toplevel
                    "commission_gift" => 1,
                    "commission_gift_value" => 3,
                    "commission_gift_desc_ar" => "", // gift commission from room
                    "commission_gift_desc_en" => "", // gift commission from room
                    "entrance_effect" => 1,
                    "entrance_effect_value" => 1,
                    "entrance_effect_desc_ar" => 1, // entrance effect
                    "entrance_effect_desc_en" => 1, // entrance effect
                    "colored_name" => 1,
                    "colored_name_value" => 1,
                    "colored_name_desc_ar" => 1, // colored_name
                    "colored_name_desc_en" => 1, // colored_name
                    "special_gift" => 1,
                    "special_gift_value" => 0,
                    "special_gift_count" => 0,
                    "special_gift_desc_ar" => 0, // special gift
                    "special_gift_desc_en" => 0, // special gift
                    "arsto_card" => 1,
                    "arsto_card_value" => 1,
                    "arsto_card_desc_ar" => "1", // arsto card desc
                    "arsto_card_desc_en" => "1", // arsto card desc
                    "vip_vehicle" => 0,
                    "vip_vehicle_value" => 0,
                    "vip_vehicle_desc_ar" => "", // vehicle
                    "vip_vehicle_desc_en" => "", // vehicle
                    "colored_messages" => 0,
                    "colored_messages_value" => 0,
                    "colored_messages_desc_ar" => "", // colored_message
                    "colored_messages_desc_en" => "", // colored_message
                    "room_password"=> 0,
                    "room_password_value"=> 0,
                    "room_password_desc_ar"=> "", // room password
                    "room_password_desc_en"=> "", // room password
                    "anti-kick" => 0,
                    "anti-kick_value" => 0,
                    "anti-kick_desc_ar" => "", // anti kick
                    "anti-kick_desc_en" => "", // anti kick
                    "hide_country" => 0,
                    "hide_country_value" => 0,
                    "hide_country_desc_ar" => "", // hide country
                    "hide_country_desc_en" => "", // hide country
                    "anti-ban-chat"=> 0,
                    "anti-ban-chat_value"=> 0,
                    "anti-ban-chat_desc_ar"=> "", // ban chat
                    "anti-ban-chat_desc_en"=> "", // ban chat
                    "exp" => 0,
                    "exp_value" => 0,
                    "exp_value_desc_ar" => "", // exp % gain
                    "exp_value_desc_en" => "", // exp % gain
                    "support_first" => 0,
                    "support_value" => 0,
                    "support_desc_ar" => "",  // support desc
                    "support_desc_en" => "",  // support desc
                    "upload_background" => 0,
                    "upload_background_value" => 0,
                    "upload_background_desc_ar" => "", // upload background desc
                    "upload_background_desc_en" => "", // upload background desc
                    "daily_login_reward" => 1,
                    "daily_login_reward_value" => 300,
                    "daily_login_reward_desc_ar" => "",
                    "daily_login_reward_desc_en" => "",
                ]
            )
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip3',
            'price' => '66000',
            'renew_price' => '49500',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_logo_value" => 1,
                    "vip_logo_desc_ar" => 1, // logo
                    "vip_logo_desc_en" => 1, // logo
                    "vip_mic_border" => 1,
                    "vip_mic_border_value" => 1,
                    "vip_mic_border_desc_ar" => 1, // mic border
                    "vip_mic_border_desc_en" => 1, // mic border
                    "topLevel" =>1,
                    "topLevel_value" =>1,
                    "topLevel_desc_ar" =>1, // toplevel
                    "topLevel_desc_en" =>1, // toplevel
                    "commission_gift" => 1,
                    "commission_gift_value" => 2.5,
                    "commission_gift_desc_ar" => 2.5, // gift commission from room
                    "commission_gift_desc_en" => 2.5, // gift commission from room
                    "entrance_effect" => 1,
                    "entrance_effect_value" => 1,
                    "entrance_effect_desc_ar" => 1, // entrance effect
                    "entrance_effect_desc_en" => 1, // entrance effect
                    "colored_name" => 1,
                    "colored_name_value" => 1,
                    "colored_name_desc_ar" => 1, // colored_name
                    "colored_name_desc_en" => 1, // colored_name
                    "special_gift" => 1,
                    "special_gift_value" => 0,
                    "special_gift_count" => 0,
                    "special_gift_desc_ar" => 0, // special gift
                    "special_gift_desc_en" => 0, // special gift
                    "arsto_card" => 1,
                    "arsto_card_value" => 1,
                    "arsto_card_desc_ar" => "1", // arsto card desc
                    "arsto_card_desc_en" => "1", // arsto card desc
                    "vip_vehicle" => 0,
                    "vip_vehicle_value" => 0,
                    "vip_vehicle_desc_ar" => "", // vehicle
                    "vip_vehicle_desc_en" => "", // vehicle
                    "colored_messages" => 0,
                    "colored_messages_value" => 0,
                    "colored_messages_desc_ar" => "", // colored_message
                    "colored_messages_desc_en" => "", // colored_message
                    "room_password"=> 0,
                    "room_password_value"=> 0,
                    "room_password_desc_ar"=> "", // room password
                    "room_password_desc_en"=> "", // room password
                    "anti-kick" => 0,
                    "anti-kick_value" => 0,
                    "anti-kick_desc_ar" => "", // anti kick
                    "anti-kick_desc_en" => "", // anti kick
                    "hide_country" => 0,
                    "hide_country_value" => 0,
                    "hide_country_desc_ar" => "", // hide country
                    "hide_country_desc_en" => "", // hide country
                    "anti-ban-chat"=> 0,
                    "anti-ban-chat_value"=> 0,
                    "anti-ban-chat_desc_ar"=> "", // ban chat
                    "anti-ban-chat_desc_en"=> "", // ban chat
                    "exp" => 0,
                    "exp_value" => 0,
                    "exp_value_desc_ar" => "", // exp % gain
                    "exp_value_desc_en" => "", // exp % gain
                    "support_first" => 0,
                    "support_value" => 0,
                    "support_desc_ar" => "",  // support desc
                    "support_desc_en" => "",  // support desc
                    "upload_background" => 0,
                    "upload_background_value" => 0,
                    "upload_background_desc_ar" => "", // upload background desc
                    "upload_background_desc_en" => "", // upload background desc
                    "daily_login_reward" => 1,
                    "daily_login_reward_value" => 400,
                    "daily_login_reward_desc_ar" => "",
                    "daily_login_reward_desc_en" => "",
                ]
            )
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip4',
            'price' => '300000',
            'renew_price' => '225000',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_logo_value" => 1,
                    "vip_logo_desc_ar" => 1, // logo
                    "vip_logo_desc_en" => 1, // logo
                    "vip_mic_border" => 1,
                    "vip_mic_border_value" => 1,
                    "vip_mic_border_desc_ar" => 1, // mic border
                    "vip_mic_border_desc_en" => 1, // mic border
                    "topLevel" =>1,
                    "topLevel_value" =>1,
                    "topLevel_desc_ar" =>1, // toplevel
                    "topLevel_desc_en" =>1, // toplevel
                    "commission_gift" => 1,
                    "commission_gift_value" => 2.5,
                    "commission_gift_desc_ar" => 2.5, // gift commission from room
                    "commission_gift_desc_en" => 2.5, // gift commission from room
                    "entrance_effect" => 1,
                    "entrance_effect_value" => 1,
                    "entrance_effect_desc_ar" => 1, // entrance effect
                    "entrance_effect_desc_en" => 1, // entrance effect
                    "colored_name" => 1,
                    "colored_name_value" => 1,
                    "colored_name_desc_ar" => 1, // colored_name
                    "colored_name_desc_en" => 1, // colored_name
                    "special_gift" => 1,
                    "special_gift_value" => 0,
                    "special_gift_count" => 0,
                    "special_gift_desc_ar" => 0, // special gift
                    "special_gift_desc_en" => 0, // special gift
                    "arsto_card" => 1,
                    "arsto_card_value" => 1,
                    "arsto_card_desc_ar" => "1", // arsto card desc
                    "arsto_card_desc_en" => "1", // arsto card desc
                    "vip_vehicle" => 0,
                    "vip_vehicle_value" => 0,
                    "vip_vehicle_desc_ar" => "", // vehicle
                    "vip_vehicle_desc_en" => "", // vehicle
                    "colored_messages" => 0,
                    "colored_messages_value" => 0,
                    "colored_messages_desc_ar" => "", // colored_message
                    "colored_messages_desc_en" => "", // colored_message
                    "room_password"=> 0,
                    "room_password_value"=> 0,
                    "room_password_desc_ar"=> "", // room password
                    "room_password_desc_en"=> "", // room password
                    "anti-kick" => 0,
                    "anti-kick_value" => 0,
                    "anti-kick_desc_ar" => "", // anti kick
                    "anti-kick_desc_en" => "", // anti kick
                    "hide_country" => 0,
                    "hide_country_value" => 0,
                    "hide_country_desc_ar" => "", // hide country
                    "hide_country_desc_en" => "", // hide country
                    "anti-ban-chat"=> 0,
                    "anti-ban-chat_value"=> 0,
                    "anti-ban-chat_desc_ar"=> "", // ban chat
                    "anti-ban-chat_desc_en"=> "", // ban chat
                    "exp" => 0,
                    "exp_value" => 0,
                    "exp_value_desc_ar" => "", // exp % gain
                    "exp_value_desc_en" => "", // exp % gain
                    "support_first" => 0,
                    "support_value" => 0,
                    "support_desc_ar" => "",  // support desc
                    "support_desc_en" => "",  // support desc
                    "upload_background" => 0,
                    "upload_background_value" => 0,
                    "upload_background_desc_ar" => "", // upload background desc
                    "upload_background_desc_en" => "", // upload background desc
                    "daily_login_reward" => 1,
                    "daily_login_reward_value" => 1000,
                    "daily_login_reward_desc_ar" => "",
                    "daily_login_reward_desc_en" => "",
                ]
            )
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip5',
            'price' => '600000',
            'renew_price' => '450000',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_logo_value" => 1,
                    "vip_logo_desc_ar" => 1, // logo
                    "vip_logo_desc_en" => 1, // logo
                    "vip_mic_border" => 1,
                    "vip_mic_border_value" => 1,
                    "vip_mic_border_desc_ar" => 1, // mic border
                    "vip_mic_border_desc_en" => 1, // mic border
                    "topLevel" =>1,
                    "topLevel_value" =>1,
                    "topLevel_desc_ar" =>1, // toplevel
                    "topLevel_desc_en" =>1, // toplevel
                    "commission_gift" => 1,
                    "commission_gift_value" => 2.5,
                    "commission_gift_desc_ar" => 2.5, // gift commission from room
                    "commission_gift_desc_en" => 2.5, // gift commission from room
                    "entrance_effect" => 1,
                    "entrance_effect_value" => 1,
                    "entrance_effect_desc_ar" => 1, // entrance effect
                    "entrance_effect_desc_en" => 1, // entrance effect
                    "colored_name" => 1,
                    "colored_name_value" => 1,
                    "colored_name_desc_ar" => 1, // colored_name
                    "colored_name_desc_en" => 1, // colored_name
                    "special_gift" => 1,
                    "special_gift_value" => 0,
                    "special_gift_count" => 0,
                    "special_gift_desc_ar" => 0, // special gift
                    "special_gift_desc_en" => 0, // special gift
                    "arsto_card" => 1,
                    "arsto_card_value" => 1,
                    "arsto_card_desc_ar" => "1", // arsto card desc
                    "arsto_card_desc_en" => "1", // arsto card desc
                    "vip_vehicle" => 0,
                    "vip_vehicle_value" => 0,
                    "vip_vehicle_desc_ar" => "", // vehicle
                    "vip_vehicle_desc_en" => "", // vehicle
                    "colored_messages" => 0,
                    "colored_messages_value" => 0,
                    "colored_messages_desc_ar" => "", // colored_message
                    "colored_messages_desc_en" => "", // colored_message
                    "room_password"=> 0,
                    "room_password_value"=> 0,
                    "room_password_desc_ar"=> "", // room password
                    "room_password_desc_en"=> "", // room password
                    "anti-kick" => 0,
                    "anti-kick_value" => 0,
                    "anti-kick_desc_ar" => "", // anti kick
                    "anti-kick_desc_en" => "", // anti kick
                    "hide_country" => 0,
                    "hide_country_value" => 0,
                    "hide_country_desc_ar" => "", // hide country
                    "hide_country_desc_en" => "", // hide country
                    "anti-ban-chat"=> 0,
                    "anti-ban-chat_value"=> 0,
                    "anti-ban-chat_desc_ar"=> "", // ban chat
                    "anti-ban-chat_desc_en"=> "", // ban chat
                    "exp" => 0,
                    "exp_value" => 0,
                    "exp_value_desc_ar" => "", // exp % gain
                    "exp_value_desc_en" => "", // exp % gain
                    "support_first" => 0,
                    "support_value" => 0,
                    "support_desc_ar" => "",  // support desc
                    "support_desc_en" => "",  // support desc
                    "upload_background" => 0,
                    "upload_background_value" => 0,
                    "upload_background_desc_ar" => "", // upload background desc
                    "upload_background_desc_en" => "", // upload background desc
                    "daily_login_reward" => 1,
                    "daily_login_reward_value" => 2000,
                    "daily_login_reward_desc_ar" => "",
                    "daily_login_reward_desc_en" => "",
                ]
            )
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip6',
            'price' => '900000',
            'renew_price' => '675000',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_logo_value" => 1,
                    "vip_logo_desc_ar" => 1, // logo
                    "vip_logo_desc_en" => 1, // logo
                    "vip_mic_border" => 1,
                    "vip_mic_border_value" => 1,
                    "vip_mic_border_desc_ar" => 1, // mic border
                    "vip_mic_border_desc_en" => 1, // mic border
                    "topLevel" =>1,
                    "topLevel_value" =>1,
                    "topLevel_desc_ar" =>1, // toplevel
                    "topLevel_desc_en" =>1, // toplevel
                    "commission_gift" => 1,
                    "commission_gift_value" => 2.5,
                    "commission_gift_desc_ar" => 2.5, // gift commission from room
                    "commission_gift_desc_en" => 2.5, // gift commission from room
                    "entrance_effect" => 1,
                    "entrance_effect_value" => 1,
                    "entrance_effect_desc_ar" => 1, // entrance effect
                    "entrance_effect_desc_en" => 1, // entrance effect
                    "colored_name" => 1,
                    "colored_name_value" => 1,
                    "colored_name_desc_ar" => 1, // colored_name
                    "colored_name_desc_en" => 1, // colored_name
                    "special_gift" => 1,
                    "special_gift_value" => 0,
                    "special_gift_count" => 0,
                    "special_gift_desc_ar" => 0, // special gift
                    "special_gift_desc_en" => 0, // special gift
                    "arsto_card" => 1,
                    "arsto_card_value" => 1,
                    "arsto_card_desc_ar" => "1", // arsto card desc
                    "arsto_card_desc_en" => "1", // arsto card desc
                    "vip_vehicle" => 0,
                    "vip_vehicle_value" => 0,
                    "vip_vehicle_desc_ar" => "", // vehicle
                    "vip_vehicle_desc_en" => "", // vehicle
                    "colored_messages" => 0,
                    "colored_messages_value" => 0,
                    "colored_messages_desc_ar" => "", // colored_message
                    "colored_messages_desc_en" => "", // colored_message
                    "room_password"=> 0,
                    "room_password_value"=> 0,
                    "room_password_desc_ar"=> "", // room password
                    "room_password_desc_en"=> "", // room password
                    "anti-kick" => 0,
                    "anti-kick_value" => 0,
                    "anti-kick_desc_ar" => "", // anti kick
                    "anti-kick_desc_en" => "", // anti kick
                    "hide_country" => 0,
                    "hide_country_value" => 0,
                    "hide_country_desc_ar" => "", // hide country
                    "hide_country_desc_en" => "", // hide country
                    "anti-ban-chat"=> 0,
                    "anti-ban-chat_value"=> 0,
                    "anti-ban-chat_desc_ar"=> "", // ban chat
                    "anti-ban-chat_desc_en"=> "", // ban chat
                    "exp" => 0,
                    "exp_value" => 0,
                    "exp_value_desc_ar" => "", // exp % gain
                    "exp_value_desc_en" => "", // exp % gain
                    "support_first" => 0,
                    "support_value" => 0,
                    "support_desc_ar" => "",  // support desc
                    "support_desc_en" => "",  // support desc
                    "upload_background" => 0,
                    "upload_background_value" => 0,
                    "upload_background_desc_ar" => "", // upload background desc
                    "upload_background_desc_en" => "", // upload background desc
                    "daily_login_reward" => 1,
                    "daily_login_reward_value" => 3000,
                    "daily_login_reward_desc_ar" => "",
                    "daily_login_reward_desc_en" => "",
                ]
            )
        ]);
    }
}
