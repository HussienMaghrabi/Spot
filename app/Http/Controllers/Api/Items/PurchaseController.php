<?php

namespace App\Http\Controllers\Api\Items;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User;
use App\Models\User_Item;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lang =$this->lang();
        $auth = $this->auth();
        $data['user'] = User_Item::where('user_id',$auth)->select('id','item_id','is_activated','time_of_exp')->get();
        $data['user']->map(function ($item) use ($lang){
            $item->Item_name = $item->item->name ;
            $item->Item_img = $item->item->img_link ;

            unset($item->item);
            unset($item->item_id);
        });

        return $this->successResponse($data);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
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
        $var = request('item_id');
        $query = Item::where('id' , $var)->pluck('duration');
        $duration = $query[0];
        $price = $user_coins - $item_price ;

        $item = User_Item::where('item_id', $request->item_id)->pluck('item_id')->first();

        if(!$item){
            if($user_coins >= $item_price){
                $mutable = Carbon::now();
                $modifiedMutable = $mutable->add($duration, 'day');
                //dd($modifiedMutable);
                $input = $request->all();
                $input['user_id'] = $auth;
                $input['is_activated'] = 1;
                $input['time_of_exp'] = $modifiedMutable->isoFormat('Y-MM-DD');

                User::Where('id',$auth)->update(['coins' => $price ]);


                $data['item'] = User_Item::create($input);
                return $this->successResponse($data, __('api.PaymentSuccess'));
            }else{
                return $this->errorResponse(__('api.NoCoins'));
            }
        }else{
            if($user_coins >= $item_price){
                $old_time_of_exp = User_Item::where('item_id', $request->item_id)->pluck('time_of_exp');


                $time = $old_time_of_exp[0];
                $again = (new Carbon($time))->add($duration , 'day')->format('Y.m.d');

                User::Where('id',$auth)->update(['coins' => $price ]);

                $data['item'] = User_Item::where('item_id', $request->item_id)->update(['time_of_exp' => $again ]);
                return $this->successResponse($data, __('api.PaymentSuccess'));
            }else{
                return $this->errorResponse(__('api.NoCoins'));
            }

        }



    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
