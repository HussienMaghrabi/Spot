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
                    "commission_gift" => 1,
                    "commission_gift_value" => 2.5,
                    "commission_gift_desc_ar" => 2.5, // gift commission from rom
                    "commission_gift_desc_en" => 2.5, // gift commission from rom
                    "entrance_effect" => 1,
                    "entrance_effect_value" => 1,
                    "entrance_effect_desc_ar" => 1, // login effect
                    "entrance_effect_desc_en" => 1, // login effect
                    "colored_name" => 1,
                    "colored_name_value" => 1,
                    "colored_name_desc_ar" => 1, // colored_name
                    "colored_name_desc_en" => 1, // colored_name
                    "topLevel" =>1,
                    "topLevel_value" =>1,
                    "topLevel_desc_ar" =>1, // toplevel
                    "topLevel_desc_en" =>1, // toplevel
                    "room_password"=>1,
                    "room_password_value"=>1,
                    "room_password_desc_ar"=>1, // room password
                    "room_password_desc_en"=>1, // room password
                    "anti-kick" => 1,
                    "anti-kick_value" => 1,
                    "anti-kick_desc_ar" => 1, // anti kick
                    "anti-kick_desc_en" => 1, // anti kick
                    "hide_country" => 0,
                    "hide_country_value" => 0,
                    "hide_country_desc_ar" => 0, // hide country
                    "hide_country_desc_en" => 0, // hide country
                    "anti-ban-chat"=>1,
                    "anti-ban-chat_value"=>1,
                    "anti-ban-chat_desc_ar"=>1, // ban chat
                    "anti-ban-chat_desc_en"=>1, // ban chat
                    "exp" => 1,
                    "exp_value" => 2,
                    "exp_value_desc_ar" => 2, // exp % gain
                    "exp_value_desc_en" => 2, // exp % gain
                    "special_gift" => 1,
                    "special_gift_value" => 0,
                    "special_gift_count" => 0,
                    "special_gift_desc_ar" => 0, // special gift
                    "special_gift_desc_en" => 0, // special gift
                    "color_name" => "red",
                    "arsto_card" => 1,
                    "arsto_card_id" => 1,
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
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored_name" => 1,
                    "topLevel" =>1,
                    "color_name" => "red",
                    "arsto_card" => 1,
                    "arsto_card_id" => 1,
                    "room_password"=>1,
                    "anti-kick" => 1,
                    "anti-ban-chat"=>1,
                    "exp" => 1,
                    "exp_value" => 2,
                    "hide_country" => 0,
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
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored_name" => 1,
                    "topLevel" =>1,
                    "color_name" => "red",
                    "arsto_card" => 1,
                    "arsto_card_id" => 1,
                    "room_password"=>1,
                    "anti-kick" => 1,
                    "anti-ban-chat"=>1,
                    "exp" => 1,
                    "exp_value" => 2,
                    "hide_country" => 0,
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
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored_name" => 1,
                    "topLevel" =>1,
                    "color_name" => "red",
                    "arsto_card" => 1,
                    "arsto_card_id" => 1,
                    "room_password"=>1,
                    "anti-kick" => 1,
                    "anti-ban-chat"=>1,
                    "exp" => 1,
                    "exp_value" => 2,
                    "hide_country" => 0,
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
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored_name" => 1,
                    "topLevel" =>1,
                    "color_name" => "red",
                    "arsto_card" => 1,
                    "arsto_card_id" => 1,
                    "room_password"=>1,
                    "anti-kick" => 1,
                    "anti-ban-chat"=>1,
                    "exp" => 1,
                    "exp_value" => 2,
                    "hide_country" => 0,
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
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored_name" => 1,
                    "topLevel" =>1,
                    "color_name" => "red",
                    "arsto_card" => 1,
                    "arsto_card_id" => 1,
                    "room_password"=>1,
                    "anti-kick" => 1,
                    "anti-ban-chat"=>1,
                    "exp" => 1,
                    "exp_value" => 2,
                    "gift_id" => 7,
                    "gift_amount" => 9,
                    "hide_country" => 0,
                ]
            )
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip7',
            'price' => '3000',
            'renew_price' => '2970',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored_name" => 1,
                    "topLevel" =>1,
                    "color_name" => "red",
                    "arsto_card" => 1,
                    "arsto_card_id" => 1,
                    "room_password"=>1,
                    "anti-kick" => 1,
                    "anti-ban-chat"=>1,
                    "exp" => 1,
                    "exp_value" => 2,
                    "daily_login" => 1,
                    "daily_gift" => 4000,
                    "gift_id" => 7,
                    "gift_amount" => 11,
                    "hide_country" => 1,
                ]
            )
        ]);
    }
}
