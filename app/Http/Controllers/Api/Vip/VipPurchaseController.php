<?php

namespace App\Http\Controllers\Api\Vip;

use App\Http\Controllers\Api\Items\ItemController;
use App\Http\Controllers\Api\Items\PurchaseController;
use App\Http\Controllers\Controller;
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
        $user =  User::where('id', $auth)->first();
        $vip = Vip_tiers::where('id', $vipID)->first();
        $userCoins = $user->coins;
        $vipTierPrice = $vip->price;
        if(($userCoins-$vipTierPrice) >= 0){
            $newUserCoins = $userCoins-$vipTierPrice;
            $now = Carbon::now()->format('Y-m-d');
             if($vip->privileges['gift_id'])
             {
                 $newUserGift = $vip->privileges['gift_id'];
                 $newUserGiftAmount = $vip->privileges['gift_amount'];
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
             $items = Item::where('vip_item',$vipID)->get();
             if ($items){
                 foreach ($items as $item){
                     $request['item_id'] = $item->id;
                     $request['category_id'] = $item->type;
                     $var = new PurchaseController();
                     $var->create($request);
                     $var1 = new ItemController();
                     $var1->activate($request);
                 }
             }
            $user->update(['coins' => $newUserCoins, 'vip_role' => $vipID, 'date_vip' => $now]);
            $message = __('api.PaymentSuccess');
            return $this->successResponse(null, $message);
        }else{
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
                // if($user->vip->privileges['commetion_gift'] == 1)
                // {
                //     $newCoins = ($newCoins + $user->vip->privileges['commetion_gift_value']);
                // }
                $user->update(['coins' => $newCoins, 'date_vip' => $newDate]);
                $items = Item::where('vip_item',$user->vip_role)->get();
                if ($items){
                    foreach ($items as $item){
                        $request['item_id'] = $item->id;
                        $request['category_id'] = $item->type;
                        $var = new PurchaseController();
                        $var->create($request);
                        $var1 = new ItemController();
                        $var1->activate($request);
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
