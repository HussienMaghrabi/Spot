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
    public function privileges($collection)
    {
        return json_encode([
            "vip_logo"             => ($collection[0]->vip_logo) ? $collection[0]->vip_logo : 0,
            "vip_mic_border"       => ($collection['vip_mic_border']) ? $collection['vip_mic_border'] : 0,
            "commetion_gift"       => ($collection['commetion_gift']) ? $collection['commetion_gift'] : 0,
            "commetion_gift_value" => ($collection['commetion_gift_value']) ? $collection['commetion_gift_value'] : 0,
            "login_effect"         => ($collection['login_effect']) ? $collection['login_effect'] : 0,
            "colored"              => ($collection['colored']) ? $collection['colored'] : 0,
            "topLevel"             => ($collection['topLevel']) ? $collection['topLevel'] : 0,
            "color_name"           => ($collection['color_name']) ? $collection['color_name'] : 0,
            "special_gift"         => ($collection['special_gift']) ? $collection['special_gift'] : 0,
            "special_gift_id"      => ($collection['special_gift_id']) ? $collection['special_gift_id'] : 0,
            "arsto_card"           => ($collection['arsto_card']) ? $collection['arsto_card'] : 0,
            "arsto_card_id"        => ($collection['arsto_card_id']) ? $collection['arsto_card_id'] : 0,
            "room_password"        => ($collection['room_password']) ? $collection['room_password'] : 0,
            "anti-kick"            => ($collection['anti-kick']) ? $collection['anti-kick'] : 0,
            "anti-ban-chat"        => ($collection['anti-ban-chat']) ? $collection['anti-ban-chat'] : 0,
            "exp"                  => ($collection['exp']) ? $collection['exp'] : 0,
            "exp_value"            => ($collection['exp_value']) ? $collection['exp_value'] : 0,
            "hide_country"         => ($collection['hide_country']) ? $collection['hide_country'] : 0,
        ]);
    }
    public function run()
    {
        DB::table('vip_tiers')->insert([
            'name' => 'Vip1',
            'price' => '100',
            'renew_price' => '98',
            'privileges' => self::privileges(
                [
                    "commetion_gift_value" => 2.5,
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
                    "commetion_gift_value" => 3.5,
                    "login_effect" => 1,
                    "colored" => 1,
                    "topLevel" =>1,
                    "arsto_card_id" => 1,
                    "room_password"=>1,
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
            'privileges' => json_encode()
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip4',
            'price' => '800',
            'renew_price' => '790',
            'privileges' => json_encode()
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip5',
            'price' => '1000',
            'renew_price' => '990',
            'privileges' => json_encode(
                [
                    "vip_logo" => 5,
                    "vip_mic_border" => 4,
                    "topLevel" =>1,
                    "color_name" => "blue",
                    "special_gift" => 1,
                    "special_gift_id" => 1,
                    "arsto_card" => 1,
                ]
            )
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip6',
            'price' => '2000',
            'renew_price' => '1980',
            'privileges' => json_encode()
        ]);
        DB::table('vip_tiers')->insert([
            'name' => 'Vip7',
            'price' => '3000',
            'renew_price' => '2970',
            'privileges' => json_encode(
                [
                    "vip_logo" => 7,
                    "vip_mic_border" => 7,
                    "commetion_gift" => 1,
                    "commetion_gift_value" => 5.0,
                    "hide_country" => 1,
                ]
            )
        ]);
    }
}
