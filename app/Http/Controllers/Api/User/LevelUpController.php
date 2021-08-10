<?php

namespace App\Http\Controllers\Api\User;

use App\Models\ChargingLevel;
use App\Models\Item;
use App\Models\karizma_level;
use App\Models\Level;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\userChargingLevel;

class LevelUpController extends Controller
{
    public function user_level()
    {
        $auth = $this->auth();
        if($auth){
            $item = User::where('id',$auth)->select('user_level','karizma_level','curr_exp','karizma_exp')->first();
            $data_level = $item->user_level + 1 ;
            $data_karizma = $item->karizma_level + 1 ;
            $data['level'] = Level::where('id',$data_level)->select('name','points','coins')->first();
            $data['karizma'] = karizma_level::where('id',$data_karizma)->select('name','points','item_id')->first();

            if($data['level']->coins == null){
                $final['level'] = Level::where('id',$data_level)->select('name','points')->first();
            }else{
                $final['level'] = $data['level'];
            }
            $final['level']->remain = $final['level']->points - $item->curr_exp;
            $final['level']->current_level = $item->user_level;
            $final['level']->current_point = $item->curr_exp;

            if($data['karizma']->item_id == null){
                $final['karizma'] =  karizma_level::where('id',$data_karizma)->select('name','points')->first();
            }else{
                $final['karizma'] =  karizma_level::where('id',$data_karizma)->select('name','points','item_id')->get();
                $final['karizma']->map(function ($var){
                    $var->item_name = $var->item->name;
                    $var->image = $var->item->img_link;
                    $var->duration = $var->item->duration;

                    unset($var->item);
                    unset($var->item_id);
                });
            }
            $final['karizma']->remain = $final['karizma']->points - $item->karizma_exp;
            $final['karizma']->current_points =$item->karizma_exp;
            $final['karizma']->current_Level =$item->karizma_level;
            $message = __('api.success');
            return $this->successResponse($final,$message);

        }else{
            $message = __('api.Authorization');
            return $this->errorResponse($message,[]);
        }
    }

    public function charge_level()
    {
        $auth = $this->auth();
        if($auth){
            $item = userChargingLevel::where('user_id',$auth)->select('user_level','coins')->first();
            $data_level = $item->user_level + 1 ;
            $query = ChargingLevel::where('id',$data_level)->pluck('gift_id')->toArray();

            if($query[0] == null){
                $finalArray =  ChargingLevel::where('id',$data_level)->select('level_limit','levelNo')->first();
            }else {
                $gift_id = ChargingLevel::where('id',$data_level)->pluck('gift_id')->toArray();
                $final = ChargingLevel::where('id', $data_level)->select('level_limit', 'levelNo')->first();
                $final->current_points = $item->coins;
                $final->current_level = $item->user_level;
                $final->remain = $final->level_limit - $item->coins;
                $finalArray = $final->toArray();
                $gifts = Item::whereIn('id',$gift_id[0])->select('name','img_link as image', 'duration')->get();
                array_push($finalArray,$gifts);
            }
            $message = __('api.success');

            return $this->successResponse($finalArray,$message);
        }else{
            $message = __('api.Authorization');
            return $this->errorResponse($message,[]);
        }
    }
}


