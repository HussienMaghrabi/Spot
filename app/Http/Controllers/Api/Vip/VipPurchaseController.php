<?php

namespace App\Http\Controllers\Api\Vip;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vip_tiers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VipPurchaseController extends Controller
{
    public function purchaseVip(Request $request){
        $auth = $this->auth();
        $vipID = $request->input('vip_id');
        $user =  User::where('id', $auth)->first();
        $vip = Vip_tiers::where('id', $vipID)->first();
        $userCoins = $user->coins;
        $vipTierPrice = $vip->price;
        if(($userCoins-$vipTierPrice) >= 0){
            $newUserCoins = $userCoins-$vipTierPrice;
            $now = Carbon::now()->format('Y-m-d');
            $user->update(['coins' => $newUserCoins, 'vip_role' => $vipID, 'date_vip' => $now]);
            $message = __('api.PaymentSuccess');
            return $this->successResponse(null, $message);
        }
        else{
            $message = __('api.insufficient_coins');
            return $this->errorResponse($message);
        }

    }

    public function renewVip(){
        $auth = $this->auth();
        $user = User::where('id', $auth)->first();
        $now = Carbon::now();
        $next = Carbon::createFromDate($user->date_vip)->addMonth();
        $diff = $now->diffInDays($next);
        if($now <= $next){
            if($user->coins >= $user->vip->renew_price){
                $newCoins = $user->coins - $user->vip->renew_price;
                $newDate = $next;
                $user->update(['coins' => $newCoins, 'date_vip' => $newDate]);
                $message = __('api.PaymentSuccess');
                return $this->successResponse(null, $message);
            }else{
                $message = __('api.insufficient_coins');
                return $this->errorResponse($message);
            }
        }else{
            $message = __('api.not_eligible');
            return $this->errorResponse($message);
        }
    }


}
