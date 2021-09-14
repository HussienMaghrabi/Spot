<?php

namespace App\Http\Controllers\Api\Items;

use App\Http\Controllers\Api\levels\levelController;
use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Coins_purchased;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User;
use App\Models\User_Item;
use App\Models\UserBadge;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = $this->lang();
        $auth = $this->auth();


        $data['user'] = User_Item::where('user_id', $auth)->select('id', 'item_id', 'is_activated', 'time_of_exp')->with('item')->paginate(15);
        $data['user']->map(function ($item) use ($lang) {
            $item->Item_name = $item->item->name;
            $item->Item_img = $item->getImageAttribute($item->item->img_link);   // fix image link Done
            $item->Item_file = $item->item->file;//getImageAttribute($item->item->img_link);
            $item->Category_id = $item->item->cat_id;
            $item->Category_name = $item->item->category["name_$lang"];  // based on lang Done
            unset($item->item);
            unset($item->item_id);

        });
        $array[] = null;
        $it = 0;
        $sql = ItemCategory::all();
        foreach ($sql as $cat){
            $array[$it] = $cat["name_$lang"];  // based on lang Done
            $it++;
        }
        $finalData = [];
        foreach ($array as $cat){
            $list = [];
            $it = 0;
            foreach ($data['user'] as $user_item){
                if($user_item->Category_name === $cat){
                    array_push($list,$user_item);
                }
                $it++;
            }
            $finalData[$cat] = $list;
        }
        return $this->successResponse($finalData);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $this->auth();
        $rules =  [
            'item_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $user_coins = User::Where('id',$auth)->pluck('coins')->first();
        $item_price = Item::where('id', $request->item_id)->pluck('price')->first();
        $item_name = Item::where('id', $request->item_id)->pluck('name')->first();
        $var = request('item_id');
        $query = Item::where('id' , $var)->pluck('duration');
        $duration = $query[0];
        $price = $user_coins - $item_price ;

        $target_id = -1;
        if($request->has('user_id')) {
            $target_id = $request->input('user_id');
        }else{
            $target_id = $auth;
        }
        $item = User_Item::where('item_id', $request->item_id)->where('user_id' , $target_id)->pluck('item_id')->first();

        if(!$item){
            if($user_coins >= $item_price){
                $mutable = Carbon::now();
                $modifiedMutable = $mutable->add($duration, 'day');
                if ($request->vip_id){
                    $input = $request->except('vip_id','category_id');
                }else{
                    $input = $request->all();
                }
                $input['user_id'] = $target_id;
                $input['is_activated'] = 0;
                $input['time_of_exp'] = $modifiedMutable->isoFormat('Y-MM-DD');

                // adding Kaizma exp to user for receiving gifts
                if($request->has('user_id')){
                    $value = $item_price;
                    $LevelController = new levelController();
                    $LevelController->addUserKaizma($value, $target_id);
                }


                // adding coins transaction for user
                Coins_purchased::create([
                    'status'=> "Buy ". $item_name,
                    'amount' => -$item_price,
                    'date_of_purchase' =>date('Y-m-d'),
                    'user_id' => $auth
                ]);

                // adding item price to total coins spent, updating user and checking for badge
                $totalSpentCoins = User::where('id',$auth)->select('total_coins_spent')->first();
                $newTotalCoinsSpent = $totalSpentCoins['total_coins_spent'] + $item_price;
                User::Where('id',$auth)->update(['coins' => $price, 'total_coins_spent'=>$newTotalCoinsSpent ]);
                $this->badgesForBuyingItems($auth, $newTotalCoinsSpent);

                $data['item'] = User_Item::create($input);
                $data['user_coins'] = $price;
                return $this->successResponse($data, __('api.PaymentSuccess'));
            }else{
                return $this->errorResponse(__('api.NoCoins'));
            }
        }else{
            if($user_coins >= $item_price){
                $old_time_of_exp = User_Item::where('item_id', $request->item_id)->where('user_id' , $target_id)->pluck('time_of_exp');


                $time = $old_time_of_exp[0];
                $again = (new Carbon($time))->add($duration , 'day')->format('Y.m.d');

                User::Where('id',$auth)->update(['coins' => $price ]);


                // adding item price to total coins spent, updating user and checking for badge
                $totalSpentCoins = User::where('id',$auth)->select('total_coins_spent')->first();
                $newTotalCoinsSpent = $totalSpentCoins['total_coins_spent'] + $item_price;
                User::Where('id',$auth)->update(['coins' => $price, 'total_coins_spent'=>$newTotalCoinsSpent ]);
                $this->badgesForBuyingItems($auth, $newTotalCoinsSpent);

                // adding coins transaction for user
                Coins_purchased::create([
                    'status'=> "Buy ". $item_name,
                    'amount'=> -$item_price,
                    'date_of_purchase' =>date('Y-m-d'),
                    'user_id'=> $auth
                ]);

                $test = User_Item::where('item_id', $request->item_id)->where('user_id' , $target_id)->update(['time_of_exp' => $again ]);
                $data['item'] = User_Item::where('item_id', $request->item_id)->where('user_id' , $target_id)->first();
                $data['user_coins'] = $price;
                return $this->successResponse($data, __('api.PaymentSuccess'));
            }else{
                return $this->errorResponse(__('api.NoCoins'));
            }

        }

    }

    // badges for buying from store
    public function badgesForBuyingItems($id, $amount){

        $count = $amount;
        $data = Badge::where('category_id',4)->get();

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
//                $badge = Badge::where('id',$badge_id)->select('name','img_link as image')->get();
//                return $badge;
            }
        }
    }



}
