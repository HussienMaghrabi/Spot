<?php

namespace App\Http\Controllers\Api\Items;

use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use App\Models\User_Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            $data = Item::where('type',$request->category_id)->where('vip_item', null)->select('id','img_link as image','duration','price','file')->paginate(15);
            if($data == null){
                return $this->errorResponse(__('api.ItemNotFound'),[]);
            }else{
                return $this->successResponse($data);
            }
        }else{
            return $this->errorResponse(__('api.Unauthorized'),[]);
        }

    }

    public function showAllStore(){

        $lang = $this->lang();
        $array[] = null;
        $it = 0;
        $sql = ItemCategory::all();
        foreach ($sql as $cat){
            $array[$it] = $cat["name_$lang"];
            $it++;
        }

        $data = Item::where('vip_item', null)->select('id','img_link as image','duration','price','file','cat_id')->paginate(15);
        $finalData = [];
        foreach ($array as $cat){
            $list = [];
            $it = 0;
            foreach ($data as $item){
                if($item->category["name_$lang"] === $cat){
                    array_push($list,$item);
                }
                $it++;
            }
            $finalData[$cat] = $list;
        }
        return $this->successResponse($finalData);
    }

    public function showUserItemByCatId()
    {
        $auth = $this->auth();
        $items = Item::where('cat_id',request('cat_id'))->pluck('id')->toArray();
        $data =  User_Item::where('user_id',$auth)->whereIn('item_id',$items)->select('id','item_id','is_activated','time_of_exp')->get();
        if(count($data) === 0){
            return $this->errorResponse(__('api.ItemNotFound'),[]);
        }else{
            $data->map(function ($user){
                $user->item_name = $user->item->name;
                $user->image = $user->item->img_link;
                $user->file = $user->item->file;
                $user->price = $user->item->price;
                unset($user->item);
                unset($user->item_id);
            });
            return $this->successResponse($data, __('api.success'));
        }
    }

    public function showUserActiveItemByCatId()
    {
        $auth = $this->auth();
        $items = Item::where('cat_id',request('cat_id'))->pluck('id')->toArray();
        $data =  User_Item::where('user_id',$auth)->where('is_activated',1)->whereIn('item_id',$items)->select('id','item_id','is_activated','time_of_exp')->get();
        if(count($data) === 0){
            return $this->errorResponse(__('api.ItemNotFound'),[]);
        }else{
            $data->map(function ($user){
                $user->item_name = $user->item->name;
                $user->image = $user->item->img_link;
                $user->file = $user->item->file;
                $user->price = $user->item->price;
                unset($user->item);
                unset($user->item_id);
            });
            return $this->successResponse($data, __('api.success'));
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
            $item_id = (int)$item->id;

            if($target_cat == $category_id){

                if($item_id == $target_id){
                     $item::where('id',$item->id)->where('user_id' , $auth)->update(['is_activated' => 1]);
                }else{
                     $item::where('id',$item->id)->update(['is_activated' => 0]);
                }
            }
        }
        $massage = __('api.Activate');
        return $this->successResponse([],$massage);

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

        $data = User_Item::where('user_id',$auth)->where('id',$request->item_id)->first();
        $data->where('user_id',$auth)->where('id',$request->item_id)->update(['is_activated' => 0]);
        $massage = __('api.deactivate');
        return $this->successResponse([],$massage);

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
