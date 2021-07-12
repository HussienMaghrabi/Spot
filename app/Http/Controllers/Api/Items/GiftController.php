<?php

namespace App\Http\Controllers\Api\Items;

use App\Models\Badge;
use App\Models\Gift;
use App\Models\User_gifts;
use App\Models\UserBadge;
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
        $data->map(function ($item) use($auth) {
            $item->gift_id = $item->gifts->id;
            $item->total_habd =  $item->where('receiver_id', $auth)->select(DB::raw('sum(amount) as total'))->where('gift_id', $item->gift_id)->groupBy('gift_id')->get();
            $item->total = $item->total_habd[0]['total'];
            $item->name = $item->gifts->name;
            $item->image = $item->gifts->img_link;

            unset($item->gifts);
            unset($item->amount);
            unset($item->total_habd);

        });
        if ($data == null){
            return $this->errorResponse(__('api.ItemNotFound'),[]);
        }else {
            return $this->successResponse($data);
        }
    }

    public function sendGift(Request $request)
    {
        $auth = $this->auth();
        $gift_id = $request->input('gift_id');
        $amount = $request->input('amount');
        $receivers = $request->input('receivers');
        $count = count($receivers);
        app('App\Http\Controllers\Api\levels\levelController')->addUserExp($amount * $count *2);
        $price = Gift::where('id', $gift_id)->pluck('price')->first();
        $gems = (($price * $amount) / 10)*3;
        $gift_price = $price * $amount;
        $total_price = $gift_price * $count;
        $user = User::where('id',$auth)->select('coins')->first();

        if($user['coins'] >= $total_price){
        $mutable = Carbon::now();
//  Room owner commetion value
            $new_coins = $user['coins'] - $total_price;
            User::Where('id',$auth)->update(['coins' => $new_coins]);
            if($request->has('room_id')){
                $user = Room::with('user')->where('id',$request->input('room_id'))->first()->user;
                $user_vip_role = $user->vip_role;
                if($user_vip_role){
                    // dd('sadwdasd');
                    // get vip details
                    $vip_tirs = Vip_tiers::where('id',$user_vip_role)->first();
                    // get % of commetion
                    $commetion_price = ($total_price * $vip_tirs->privileges['commetion_gift_value'] /100);
                    // dd((int) $vip_tirs->privileges['commetion_gift_value']);
                    User::where('id',$user->id)->update([
                        'coins' => (int) $new_coins + $commetion_price,
                    ]);
                }
            }else{

            }
            for($it = 0; $it < $count; $it++){
                $user_rec = User::where('id',$receivers[$it])->select('gems')->first();
                $new_gems = $user_rec['gems'] + $gems;
                User::Where('id',$receivers[$it])->update(['gems' => $new_gems]);

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

    public function viewGifts(){
        $gifts = Gift::where('vip_item',null)->select('id','name', 'img_link as image', 'price')->orderBy('id')->get();
        return $this->successResponse($gifts, __('api.success'));
    }


}
