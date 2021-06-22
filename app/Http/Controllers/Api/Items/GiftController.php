<?php

namespace App\Http\Controllers\Api\Items;

use App\Models\Badge;
use App\Models\Gift;
use App\Models\User_gifts;
use App\Models\UserBadge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\containsIdentical;

class GiftController extends Controller
{

    public function showGifts()
    {
        $lang = $this->lang();
        $auth = $this->auth();
        $data = DB::table('user_gifts')
            ->leftJoin('gifts', 'user_gifts.gift_id','=','gifts.id')
            ->groupBy('gift_id')
            ->where('receiver_id', $auth)
            ->select('gift_id', DB::raw('sum(amount) as total'), 'gifts.name' , 'gifts.img_link')
            ->paginate(15);


//        $data = DB::table('user_gifts')
//            ->select('gift_id', DB::raw('count(*) as total'))
//            ->where('receiver_id', $auth)
//            ->groupBy('gift_id')
//            ->pluck('total','gift_id')->all();

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
        $gift_price = $price * $amount;
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
                $input['room_id'] = 1;
                $input['price_gift'] = $gift_price;
                $input['amount'] = $amount;
                $input['date_sent'] = $mutable->isoFormat('Y-MM-DD');

                $data['gift'] = User_gifts::create($input);

            }

        }else{
            $message = __('api.insufficient_coins');
            return $this->successResponse(null,$message);
        }
        $qu = Badge::where('gift_id',$gift_id)->pluck('category_id');

        $cat =$qu[0];
        if ($qu ){
            $this->badgesForSendGift($gift_id,$cat);
        }

        $message = __('api.all_gifts_sent');
        return $this->successResponse(null, $message);


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
            $var = UserBadge::where('user_id',$id)->where('category_id', $cat)->first();
            if ($var){
                if($var->badge_id != $badge_id){
                    UserBadge::where('user_id',$id)->where('category_id', $cat)->update(['badge_id'=>$badge_id]);
                }
            }else{
                $input['user_id'] = $id;
                $input['badge_id'] = $badge_id ;
                $input['category_id'] = $cat ;
                UserBadge::create($input);
            }
        }
    }


}
