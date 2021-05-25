<?php

namespace App\Http\Controllers\Api\Items;

use App\Models\Gift;
use App\Models\User_gifts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class GiftController extends Controller
{

    public function showGifts()
    {
        $lang = $this->lang();
        $auth = $this->auth();
        $data = User_gifts::where('receiver_id', $auth)->groupBy('item_id')->get();

        return $this->successResponse($data);
    }

    public function sendGift(Request $request)
    {
        $auth = $this->auth();
        $gift_id = $request->input('gift_id');
        $amount = $request->input('amount');
        $receivers = $request->input('receivers');
        $count = count($receivers);
        $price = Gift::where('id', $gift_id)->pluck('price')->first();
        $gems = (($price * $amount) / 10)*3;
        $total_price = $price * $count;
        $user = User::where('id',$auth)->select('coins')->first();
        if($user['coins'] >= $total_price){

            $new_coins = $user['coins'] - $total_price;
            User::Where('id',$auth)->update(['coins' => $new_coins]);
            $mutable = Carbon::now();
            for($it = 0; $it < $count; $it++){
                $user_rec = User::where('id',$receivers[$it])->select('gems')->first();
                $new_gems = $user_rec['gems'] + $gems;
                User::Where('id',$receivers[$it])->update(['gems' => $new_gems]);

                //$input = $request->all();
                $input['sender_id'] = $auth;
                $input['receiver_id'] = $receivers[$it];
                $input['gift_id'] = $gift_id;

                $input['amount'] = $amount;
                $input['date_sent'] = $mutable->isoFormat('Y-MM-DD');

                $data['gift'] = User_gifts::create($input);

            }

        }else{
            $message = __('insufficient coins. Please buy coins first');
            return $this->successResponse($message);
        }
        $message = __('all gifts sent');
        return $this->successResponse(null, $message);


    }
}
