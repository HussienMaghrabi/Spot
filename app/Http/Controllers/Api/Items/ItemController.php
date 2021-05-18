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
            $data = Item::where('type',$request->category_id)->select('id','img_link','price')->get();
            return $this->successResponse($data);
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }

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
