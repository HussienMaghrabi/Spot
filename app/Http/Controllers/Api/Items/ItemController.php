<?php

namespace App\Http\Controllers\Api\Items;

use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Models\User_Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

Class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $rules =  [
        'category_id'    => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }


        $auth = $this->auth();
        if($auth){
            $data = Item::where('type',$request->category_id)->select('id','img_link','price')->paginate(15);
            return $this->successResponse($data);
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate(Request  $request)
    {
        //
        $auth = $this->auth();
        $rules =  [
            'category_id' => 'required',
            'item_id'     => 'required'
        ];
        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $data = User_Item::where('user_id',$auth)->select('item_id','id','is_activated')->get();
        foreach ($data as  $item){

            $category_id = (int)$item->item['type'] ;
            $target_cat = (int)$request->category_id;
            $target_id = (int)$request->item_id;
            $item_id = (int)$item->item_id;

            if($target_cat == $category_id){

                if($item_id == $target_id){
                     $item::where('item_id',$target_id)->where('user_id' , $auth)->update(['is_activated' => 1]);
                }else{
                     $item::where('id',$item->id)->update(['is_activated' => 0]);
                }
            }
        }
        $massage = __('api.Activate');
        return $this->successResponse(null,$massage);

    }

    public function deactivate(Request  $request){
        $auth = $this->auth();
        $rules =  [
            'item_id'     => 'required'
        ];
        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $data = User_Item::where('user_id',$auth)->where('item_id',$request->item_id)->first();
        $data->where('user_id',$auth)->where('item_id',$request->item_id)->update(['is_activated' => 0]);
        $massage = __('api.deactivate');
        return $this->successResponse(null,$massage);

    }

    public function remove_exp_items(){
        $auth = $this->auth();
        $data = User_Item::where('user_id',$auth)->select('time_of_exp','id')->get();
//        dd($data);
        $now = Carbon::now()->format('Y-m-d');
        foreach ($data as  $item){
//            dd($item);
            $time = (new Carbon($item['time_of_exp']))->isoFormat('Y-MM-DD');
//            dd($time);
           if($time < $now){
               $target_id = $item['id'];
               $query = User_Item::find($target_id);
               if($query){
                   $query->delete();
                   $massage = __('api.Deleted');
                   return $this->successResponse(null,$massage);
               }
           }
        }







    }
}
