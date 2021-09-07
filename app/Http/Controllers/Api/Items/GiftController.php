<?php

namespace App\Http\Controllers\Api\Items;

use App\Http\Controllers\Api\levels\DailyExpController;
use App\Http\Controllers\Api\levels\levelController;
use App\Models\Badge;
use App\Models\Coins_purchased;
use App\Models\Gift;
use App\Models\User_gifts;
use App\Models\UserBadge;
use App\Models\UserDiamondTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Vip_tiers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\containsIdentical;
use App\Http\Controllers\Api\levels\levelController as exp;


class GiftController extends Controller
{

    public function showGifts()
    {
        $auth = $this->auth();
        $data = User_gifts::where('receiver_id', $auth)->select('id','gift_id', 'amount', 'receiver_id')->groupBy('gift_id')->get();
        if (count($data) == 0){
            return $this->errorResponse(__('api.ItemNotFound'),[]);
        }
        else{
            $data->map(function ($item) use($auth) {
                $item->gift_id = $item->gifts->id;
                $item->total_habd =  $item->where('receiver_id', $auth)->select(DB::raw('sum(amount) as total'))->where('gift_id', $item->gift_id)->groupBy('gift_id')->get();
                $item->total = $item->total_habd[0]['total'];
                $item->name = $item->gifts->name;
                $item->image = $item->gifts->img_link;
                $item->file = $item->gifts->file;

                unset($item->gifts);
                unset($item->amount);
                unset($item->total_habd);
            });
            return $this->successResponse($data, __('api.success'));
        }
    }

    public function sendGift(Request $request)
    {
        $auth = $this->auth();
        $gift_id = $request->input('gift_id');
        $amount = $request->input('amount');
        $receivers_string = $request->input('receivers');
        $receivers = explode(',', $receivers_string);
        $count = count($receivers);
        $price = Gift::where('id', $gift_id)->pluck('price')->first();
        $gift_name = Gift::where('id', $gift_id)->pluck('name')->first();
        $gems = (($price * $amount) / 10)*3;
        $gift_price = $price * $amount;
        $total_price = $gift_price * $count;
        $user = User::where('id',$auth)->select('coins')->first();

        if($user['coins'] >= $total_price){
            $mutable = Carbon::now();
            $new_coins = $user['coins'] - $total_price;
            User::Where('id',$auth)->update(['coins' => $new_coins]);

            // adding exp to user for sending number of gifts
            $dailyExpController = new DailyExpController();
            $value = $dailyExpController->checkSendGiftExp($count*$amount);
            $LevelController = new levelController();
            $LevelController->addUserExp($value, $auth);

            // adding exp to user for sending coins of gifts
            $dailyExpController = new DailyExpController();
            $value = $dailyExpController->checkCoinsSendGiftsExp($total_price);
            $LevelController = new levelController();
            $LevelController->addUserExp($value, $auth);

            // adding coins transaction for user
            Coins_purchased::create([
                'status'=> "send ". $gift_name ."as gift",
                'amount'=>-$total_price,
                'date_of_purchase'=>date('Y-m-d'),
                'user_id'=>$auth
            ]);

            if($request->has('room_id')){
                $user = Room::with('user')->where('id',$request->input('room_id'))->first()->user;
                $user_vip_role = $user->vip_role;
                if($user_vip_role != null){
                    $vip_tirs = Vip_tiers::where('id',$user_vip_role)->first();
                    if($vip_tirs->privileges['commission_gift'] == 1){
                        $user_coins = User::where('id',$user->id)->pluck('coins')->first();
                        // get % of commetion
                        $commetion_price = ($total_price * $vip_tirs->privileges['commission_gift_value'] /100);
                        User::where('id',$user->id)->update([
                            'coins' => $user_coins + $commetion_price,
                        ]);
                        $var['status'] = 'room_commetion';
                        $var['amount'] = $commetion_price;
                        $var['date_of_purchase'] = date('Y-m-d');
                        $var['user_id'] = $user->id;
                        Coins_purchased::create($var);
                    }
                }
            }
            for($it = 0; $it < $count; $it++){
                $user_rec = User::where('id',$receivers[$it])->select('gems')->first();
                $new_gems = $user_rec['gems'] + $gems;
                User::Where('id',$receivers[$it])->update(['gems' => $new_gems]);

                // adding exp to user for receiving number of gifts
                $dailyExpController = new DailyExpController();
                $value = $dailyExpController->checkReceiveGiftExp($amount, $receivers[$it]);
                $LevelController = new levelController();
                $LevelController->addUserExp($value, $receivers[$it]);

                // adding diamonds transaction for user
                UserDiamondTransaction::create([
                    'amount'=> $gems,
                    'status'=> 'receive_gift',
                    'user_id'=> $receivers[$it]
                ]);

                //$input = $request->all();
                $input['sender_id'] = $auth;
                $input['receiver_id'] = $receivers[$it];
                $input['gift_id'] = $gift_id;
                $input['room_id'] = ($request->has('room_id')) ? $request->input('room_id') : null;
                $input['price_gift'] = $gift_price;
                $input['amount'] = $amount;
                $input['date_sent'] = $mutable->isoFormat('Y-MM-DD');

                $data['gift'] = User_gifts::create($input);

            }
            // app('App\Http\Controllers\Api\levels\levelController')->addUserExp(100);
        }else{
            $message = __('api.insufficient_coins');
            return $this->successResponse([],$message);
        }


        $message = __('api.all_gifts_sent');
        return $this->successResponse($new_coins, $message);


    }

    public function badgesForSendGift($id,$cat)
    {
        $auth =  $this->auth();
        $varr = User_gifts::where('sender_id',$auth)->where('gift_id',$id)->select(DB::raw('sum(amount) as total'))->pluck('total');
        $count = (int)$varr[0];

        $data = Badge::where('category_id',$cat)->get();
        $badge_id = -1 ;
        foreach ($data as $item){
            if($count >= $item->amount){
                $badge_id =$item->id;
            }else{
                break;
            }
        }

        if ($badge_id != -1){
            $var = UserBadge::where('user_id',$id)->where('badge_id', $badge_id)->first();
            if (!$var){
                $input['user_id'] = $id;
                $input['badge_id'] = $badge_id ;
                UserBadge::create($input);
//                if($var->badge_id != $badge_id){
//                    UserBadge::where('user_id',$id)->where('category_id', $cat)->update(['badge_id'=>$badge_id]);
//                }
            }
        }
    }

    public function viewGifts(){
        $gifts = Gift::where('vip_item',null)->select('id','flag','name', 'img_link as image', 'price', 'file')->orderBy('id')->get();
        $finalData['gifts'] = [];
        $finalData['flags'] = [];

        foreach ($gifts as $gift){
            if($gift->flag == 0){
                array_push($finalData['gifts'], $gift);
            }else{
                array_push($finalData['flags'], $gift);
            }
        }
        return $this->successResponse($finalData, __('api.success'));
    }


}
