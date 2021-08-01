<?php

namespace App\Http\Controllers\Api\User;

use App\Models\chargingLevel;
use App\Models\karizma_level;
use App\Models\Level;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\userChargingLevel;
use Illuminate\Http\Request;

class LevelUpController extends Controller
{
    public function user_level()
    {
        $auth = $this->auth();
        if($auth){
            $item = User::where('id',$auth)->select('user_level','karizma_level')->first();
            $data_level = $item->user_level + 1 ;
            $data_karizma = $item->karizma_level + 1 ;
            $data['level'] = Level::where('id',$data_level)->select('points','coins')->first();
            $data['karizma'] = karizma_level::where('id',$data_karizma)->select('points','item_id')->first();

            if($data['level']->coins == null){
                $final['level'] = Level::where('id',$data_level)->select('points')->first();
            }else{
                $final['level'] = $data['level'];
            }

            if($data['karizma']->item_id == null){
                $final['karizma'] =  karizma_level::where('id',$data_karizma)->select('points')->first();
            }else{
                $final['karizma'] =  karizma_level::where('id',$data_karizma)->select('points','item_id')->get();
                $final['karizma']->map(function ($var){
                    $var->item_name = $var->item->name;
                    $var->image = $var->item->img_link;
                    $var->duration = $var->item->duration;

                    unset($var->item);
                    unset($var->item_id);
                });
            }
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
            $item = userChargingLevel::where('user_id',$auth)->select('user_level')->first();
            $data_level = $item->user_level + 1 ;
            $data = chargingLevel::where('id',$data_level)->select('level_limit','gift_id')->first();
            if($data->gift_id == null){
                $final =  chargingLevel::where('id',$data_level)->select('level_limit','levelNo')->first();
            }else{
                $final =  chargingLevel::where('id',$data_level)->select('level_limit','gift_id','levelNo')->get();
                $final->map(function ($var){
                    $var->gift_name = $var->gift->name;
                    $var->image = $var->gift->img_link;
                    $var->duration = $var->gift->price;

                    unset($var->gift);
                    unset($var->gift_id);
                });
            }
            $message = __('api.success');
            return $this->successResponse($final,$message);
        }else{
            $message = __('api.Authorization');
            return $this->errorResponse($message,[]);
        }
    }
}


