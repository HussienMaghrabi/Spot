<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\ChargingLevel;
use App\Models\userChargingLevel;
use App\Services\PayUService\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class chargeController extends Controller
{
    public function getAllLevels(Request $request)
    {
        $chargingLevel = ChargingLevel::select('id','name','level_limit','levelNo as level')->get();
        $massage = __('api.allChargeLevels');
        return $this->successResponse($chargingLevel,$massage);
}
    public function chargIng(Request $request)
    {
        $userChargingLevel = new userChargingLevel;

        $rules =  [
            'user_id' => 'required|exists:users,id',
            'coins' => 'required',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        DB::beginTransaction();
        $data = [];
        $massage = '';
        try{
            $uObj = new userChargingLevel;
            $uObj = $uObj->where('user_id',$request->input('user_id'))->first();
            $after_per = $request->input('coins') * 100;
            // $after_per = ($request->input('coins') * 100) + ($request->input('earning') * 10 / 100);
            $data['user_id'] = $request->input('user_id');
            $data['earning'] = ($uObj) ? $uObj->earning + $after_per : $after_per;
            $data['coins'] = ($uObj) ? $uObj->coins + $request->input('coins') : $request->input('coins');
            if (!$uObj) {
                $ins = userChargingLevel::create($data);
                $uObj = $ins;
            }else{
                $ins = $uObj->update($data);
            }
            if(!$ins){
                $massage = __('api.chargeintrnalError');
                return $this->errorResponse($uObj,$massage);
            }else{
                $this->gradeUserLevel($uObj);
                DB::commit();
                $massage = __('api.chargeSuccessfull');
                return $this->successResponse($uObj,$massage);
            }
            }catch(\Exception $e){
                DB::rollback();
                throw $e;
        }
    }
    public function gradeUserLevel($userObj)
    {
        // here will create a grade level buy charching
        // return true; // this retun just for complelte insert
        // get total earning
        $total = $userObj->earning;
        $user = [];
        foreach (ChargingLevel::all() as $key => $value) {
            if ($total >= $value->level_limit) {
                userChargingLevel::where('user_id',$userObj->user_id)->update(['user_level' => $value->id]);
            }else {
                break;
            }
        }
        return (Object) $user;
    }
    public function chargingList()
    {
        $auth = $this->auth();
        if ($auth){
            $data = ChargingLevel::orderBy('id', 'asc')->select('id','name')->get();
            $message = __('api.success');
            return $this->successResponse($data,$message);
        }else{
            $message = __('api.Authorization');
            return $this->errorResponse($message,[]);
        }


    }

    public function showChargingById($id)
    {
        $auth = $this->auth();
        if ($auth){
            $user_cLevel = userChargingLevel::where('user_id',$auth)->select('user_level','coins')->first();
            $query = ChargingLevel::where('id',$id)->pluck('gift_id')->toArray();
            if($query[0] != null){
                $target_cLevel = ChargingLevel::where('id',$id)->select('level_limit','badge_id', 'levelNo')->first();
                $target_cLevel->current_points = $user_cLevel->coins;
                $target_cLevel->current_level = $user_cLevel->user_level;
                $target_cLevel->remain = $target_cLevel->level_limit - $user_cLevel->coins;
                $target_cLevel->image = $target_cLevel->badges->img_link;
                $finalArray = $target_cLevel->toArray();
                $gifts = Item::whereIn('id',$query[0])->select('name','img_link as image', 'duration')->get();
                array_push($finalArray,$gifts);
            }
            else{
                $target_cLevel = ChargingLevel::where('id',$id)->select('level_limit','badge_id', 'levelNo')->first();
                $target_cLevel->current_points = $user_cLevel->coins;
                $target_cLevel->current_level = $user_cLevel->user_level;
                $target_cLevel->remain = $target_cLevel->level_limit - $user_cLevel->coins;
                $target_cLevel->image = $target_cLevel->badges->img_link;
                $finalArray = $target_cLevel->toArray();
            }
            $message = __('api.success');
            return $this->successResponse($finalArray,$message);

//            // /*/*/*/*/*/*/*/*/*/*/*
//
//            $user_level = userChargingLevel::where('user_id',$auth)->pluck('user_level')->first();// to remove
//            $user_coins = userChargingLevel::where('user_id',$auth)->pluck('coins')->first();// to remove
//            $user_level_limit = ChargingLevel::where('id',$id)->pluck('level_limit')->first();// to remove
//            $user_level_name = ChargingLevel::where('id',$id)->pluck('name')->first();// to remove
//            $user_next_level = $user_level ;
//            $next_level_name = ChargingLevel::where('id',$user_next_level)->pluck('name')->first();// to remove
//            $need_to_next_level = $user_level_limit - $user_coins ;
//
//            $query = ChargingLevel::where('id',$id)->pluck('gift_id')->toArray();// to remove
//            if($query[0] == null){
//                $final =  ChargingLevel::where('id',$id)->select('name','level_limit','desc','badge_id','levelNo')->get();
//                $final->map(function ($item) use($user_coins,$next_level_name,$user_level_name,$need_to_next_level){
//                    $item->image = $item->badges->img_link;
//                    $item->current_points = $user_coins;
//                    $item->current_level = $next_level_name;
//                    $item->remain = $need_to_next_level;
//
//                    unset($item->badges);
//                    unset($item->name);
//                    unset($item->desc);
//                    unset($item->badge_id);
//                });
//                $finalArray = $final->toArray();
//                $gifts = [];
//                array_push($finalArray,$gifts);
//            }else {
//                $gift_id = ChargingLevel::where('id',$id)->pluck('gift_id')->toArray();
//                $final = ChargingLevel::where('id', $id)->select('name','level_limit','desc','badge_id','levelNo')->get();
//                $final->map(function ($item) use($user_coins,$next_level_name,$user_level_name,$need_to_next_level){
//                    $item->image = $item->badges->img_link;
//                    $item->current_points = $user_coins;
//                    $item->current_level = $next_level_name;
//                    $item->remain = $need_to_next_level;
//
//                    unset($item->badges);
//                    unset($item->desc);
//                    unset($item->name);
//                    unset($item->badge_id);
//                });
//                $finalArray = $final->toArray();
//                $gifts = Item::whereIn('id',$gift_id[0])->select('name','img_link as image', 'duration')->get();
//                array_push($finalArray,$gifts);
//            }
//            $message = __('api.success');
//            return $this->successResponse($finalArray,$message);
        }else{
            $message = __('api.Authorization');
            return $this->errorResponse($message,[]);
        }
    }
}
