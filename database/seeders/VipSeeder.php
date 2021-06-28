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
    //             "colored" => 1,
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
            'price' => '100',
            'renew_price' => '98',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored" => 1,
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
            'name' => 'Vip2',
            'price' => '300',
            'renew_price' => '295',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored" => 1,
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
            'price' => '500',
            'renew_price' => '495',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored" => 1,
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
            'price' => '800',
            'renew_price' => '790',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored" => 1,
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
            'price' => '1000',
            'renew_price' => '990',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored" => 1,
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
            'price' => '2000',
            'renew_price' => '1980',
            'privileges' => json_encode(
                [
                    "vip_logo" => 1,
                    "vip_mic_border" => 1,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 2.5,
                    "login_effect" => 1,
                    "colored" => 1,
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
                    "colored" => 1,
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
                    "gift_amount" => 11,

                    "hide_country" => 1,
                ]
            )
        ]);
    }
}
