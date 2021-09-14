<?php

namespace App\Http\Controllers\Api\Vip;

use App\Http\Controllers\Api\Items\ItemController;
use App\Http\Controllers\Api\Items\PurchaseController;
use App\Http\Controllers\Api\levels\levelController;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\Gift;
use App\Models\Item;
use App\Models\User;
use App\Models\User_gifts;
use App\Models\User_Item;
use App\Models\Vip_tiers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VipPurchaseController extends Controller
{
    public function purchaseVip(Request $request){
        $auth = $this->auth();
        $vipID = $request->input('vip_id');

        // if user wants to send vip
        $target_id = $auth;
        if($request->has('user_id')){
            $target_id = $request->input('user_id');
        }

        $user =  User::where('id', $auth)->first();
        $userCoins = $user->coins;
        $vip = Vip_tiers::where('id', $vipID)->first();
        $vipTierPrice = $vip->price;
        if(($userCoins-$vipTierPrice) >= 0){
            $newUserCoins = $userCoins-$vipTierPrice;
            $now = Carbon::now()->format('Y-m-d');
             if($vip->privileges['special_gift'])
             {
                 $newUserGift = $vip->privileges['special_gift_value'];
                 $newUserGiftAmount = $vip->privileges['special_gift_count'];
                 $giftPrice = Gift::where('id',$newUserGift)->pluck('price')->first();
                 $finalPrice = $giftPrice * $newUserGiftAmount;
                 User_gifts::create([
                     'receiver_id'=>$target_id,
                     'gift_id'=>$newUserGift,
                     'date_sent'=>$now,
                     'amount'=>$newUserGiftAmount,
                     'price_gift'=>$finalPrice
                 ]);
             }
             $items = Item::where('vip_item',$vipID)->get();
             if ($items){
                 foreach ($items as $item){
                     $carbonObj = Carbon::now()->addDays($item->duration)->format('Y-m-d');
                     User_Item::create([
                         'user_id' =>  $target_id,
                         'item_id' =>  $item->id,
                         'time_of_exp' =>  $carbonObj
                     ]);
                 }
             }
             if($request->has('user_id')){
                 $target_user = User::where('id', $target_id)->first();
                 $target_user->update(['vip_role' => $vipID, 'date_vip' => $now]);
                 $user->update(['coins' => $newUserCoins]);

                 // adding Kaizma exp to user for receiving gifts
                 $value = $vip->price;
                 $LevelController = new levelController();
                 $LevelController->addUserKaizma($value, $target_id);
             }
             else{
                 $user->update(['coins' => $newUserCoins, 'vip_role' => $vipID, 'date_vip' => $now]);
             }
            return $this->responseUser($auth);
        }else{
            $message = __('api.insufficient_coins');
            return $this->errorResponse($message);
        }

    }



    public function responseUser($id)
    {
        $user = User::where('id', $id)->first();
        $item = new UserResource($user);
        $message = __('api.PaymentSuccess');
        return $this->successResponse($item , $message);
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
                $items = Item::where('vip_item',$user->vip_role)->get();

                if($user->vip->privileges['special_gift'])
                {
                    $newUserGift = $user->vip->privileges['special_gift_value'];
                    $newUserGiftAmount = $user->vip->privileges['special_gift_count'];
                    $giftPrice = Gift::where('id',$newUserGift)->pluck('price')->first();
                    $finalPrice = $giftPrice * $newUserGiftAmount;
                    User_gifts::create([
                        'receiver_id'=>$auth,
                        'gift_id'=>$newUserGift,
                        'date_sent'=>$now,
                        'amount'=>$newUserGiftAmount,
                        'price_gift'=>$finalPrice
                    ]);
                }
                if ($items){
                    foreach ($items as $item){
                        $carbonObj = Carbon::now()->addDays($item->duration)->format('Y-m-d');
                        User_Item::create([
                            'user_id' =>  $auth,
                            'item_id' =>  $item->id,
                            'time_of_exp' =>  $carbonObj
                        ]);
                    }
                }
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
