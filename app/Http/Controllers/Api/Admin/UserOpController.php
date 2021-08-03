<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\Admin;
use App\Models\ChargingLevel;
use App\Models\User;
use App\Models\userChargingLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserOpController extends Controller
{

    public function userList()
    {
        $admin = $this->authAdmin();
        if($admin) {
            $data = User::orderBy('id')->select(
                'id',
                'name',
                'email',
                'api_token' ,
                'birth_date',
                'desc',
                'completed',
                'curr_exp',
                'karizma_exp',
                'coins',
                'gems' ,
                'user_level',
                'karizma_level',
                'gender' ,
                'country_id',
                'date_joined',
                "profile_pic as image",
                "vip_role",
                "date_vip",
                "created_at",
            )->paginate(10);
            $data->map(function ($item){
               $item->country_name = $item->country()->pluck('name')->first();
               $item->images = $item->user_image()->pluck('image');
            });
          return $this->successResponse($data,__('api.success'));

        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage);
        }

    }

    public function search(Request $request)
    {
        $admin = $this->authAdmin();
        if($admin) {
            $data = User::where('special_id', 'LIKE', '%'.$request->text.'%')
                ->select(
                    'id',
                    'name',
                    'email',
                    'api_token' ,
                    'birth_date',
                    'desc',
                    'completed',
                    'curr_exp',
                    'karizma_exp',
                    'coins',
                    'gems' ,
                    'user_level',
                    'karizma_level',
                    'gender' ,
                    'country_id',
                    'date_joined',
                    "profile_pic as image",
                    "vip_role",
                    "date_vip",
                    "created_at",
                )
                ->paginate(10);
            $data->map(function ($item){
                $item->country_name = $item->country()->pluck('name')->first();
                $item->images = $item->user_image()->pluck('image');
            });
            return $this->successResponse($data,__('api.success'));
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage);
        }
    }


    public function changeGender(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if ($request->has('user_id')) {
                $target_user = $request->input('user_id');
                $user = User::where('id', $target_user)->first();
                if($user === null){
                    $massage = __('api.userNotFound');
                    return $this->errorResponse($massage);
                }
                $gender = $request->input('gender');
                $user = User::where('id', $target_user)->update(['gender' => $gender]);
                $massage = __('api.success');
                return $this->successResponse($user, $massage);

            } else {
                $massage = __('api.missing_user');
                return $this->errorResponse($massage);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage);
        }
    }
    public function changeName(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if ($request->has('user_id')) {
                $target_user = $request->input('user_id');
                $user = User::where('id', $target_user)->first();
                if($user === null){
                    $massage = __('api.userNotFound');
                    return $this->errorResponse($massage);
                }
                $name = $request->input('name');
                $user = User::where('id', $target_user)->update(['name' => $name]);
                $massage = __('api.success');
                return $this->successResponse($user, $massage);
            } else {
                $massage = __('api.missing_user');
                return $this->errorResponse($massage);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage);
        }

    }

    public function changeSpecialId(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if($admin->super == 1){
                $rules =  [
                    'user_id'  => 'required',
                    'special_id'  => 'required|unique:users',
                ];

                $validator = Validator::make(request()->all(), $rules);
                $errors = $this->formatErrors($validator->errors());
                if($validator->fails()) {
                    log::debug('error message '.$errors);
                    return $this->errorResponse($errors);
                }

                User::where('id',$request->user_id)->update(['special_id'=>$request->special_id]);
                $massage = __('api.success');
                return $this->successResponse([], $massage);
            }else{
                $massage = __('api.notSuper');
                return $this->errorResponse($massage);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage);
        }
    }
    public function removeSpecialId(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if($admin->super == 1){
                $rules =  [
                    'user_id'  => 'required',
                ];

                $validator = Validator::make(request()->all(), $rules);
                $errors = $this->formatErrors($validator->errors());
                if($validator->fails()) {
                    log::debug('error message '.$errors);
                    return $this->errorResponse($errors);
                }

                User::where('id',$request->user_id)->update(['special_id'=>Str::random(9)]);
                $massage = __('api.success');
                return $this->successResponse([], $massage);
            }else{
                $massage = __('api.notSuper');
                return $this->errorResponse($massage);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage);
        }
    }

    public function rechargeNoLevel(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if($admin->super == 1){
                $rules =  [
                    'user_unique_id'  => 'required',
                    'amount' => 'required'
                ];
                $validator = Validator::make(request()->all(), $rules);
                $errors = $this->formatErrors($validator->errors());
                if($validator->fails()) {
                    log::debug('error message '.$errors);
                    return $this->errorResponse($errors,[]);
                }
                $user_unique_id = $request->input('user_unique_id');
                $addedAmount = $request->input('amount');
                $user_coins = User::where('special_id', $user_unique_id)->pluck('coins')->first();
                if($user_coins === null){
                    $massage = __('api.userNotFound');
                    return $this->errorResponse($massage, []);
                }
                $newCoins = $user_coins + $addedAmount;
                $user = User::where('special_id', $user_unique_id)->update(['coins' => $newCoins]);
                $massage = __('api.success');
                return $this->successResponse([], $massage);
            }else{
                $massage = __('api.notSuper');
                return $this->errorResponse($massage, []);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage, []);
        }
    }
    // not completed
    public function rechargeWithLevel(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if($admin->super == 1) {
                $rules = [
                    'user_unique_id' => 'required',
                    'amount' => 'required'
                ];
                $validator = Validator::make(request()->all(), $rules);
                $errors = $this->formatErrors($validator->errors());
                if ($validator->fails()) {
                    log::debug('error message ' . $errors);
                    return $this->errorResponse($errors, []);
                }
                $user_unique_id = $request->input('user_unique_id');
                $addedAmount = $request->input('amount');
                $user =User::where('special_id',$user_unique_id)->first();
                $user_level = userChargingLevel::where('user_id',$user->id)->first();
                if($user_level === null){
                    $arr['user_id'] = $user->id;
                    $arr['coins'] = 0;
                    $arr['user_level'] = 1;
                    userChargingLevel::create($arr);
                }
                $user_level = userChargingLevel::where('user_id',$user->id)->first();
                $all_limit = ChargingLevel::where('levelNo', '>=', $user_level->user_level)->get();
                $size = count($all_limit);
                if($user_level){
                    $old_coins = userChargingLevel::where('user_id',$user->id)->pluck('coins')->first();
                    $new_coins = $old_coins + $addedAmount ;
                    $old_level = $user_level->user_level;
                    $new_level = $old_level;
                    if($size != 1){
                        foreach ($all_limit as $limit){
                            if($limit->level_limit <= $new_coins){
                                $new_level = $new_level +1;
                                break;
                            }
                        }
                    }
                    userChargingLevel::where('user_id',$user->id)->update([
                        'coins'=>$new_coins,
                        'user_level'=>$new_level
                    ]);
                    $coins = $user->coins + $addedAmount;
                    $user->update(['coins' => $coins]);
                }else{
                    $old_coins = 0;
                    $new_coins = $old_coins + $addedAmount ;
                    $old_level = 1;
                    $new_level = $old_level;
                    foreach ($all_limit as $limit){
                        if($limit->level_limit <= $new_coins){
                            $new_level = $new_level +1;
                        }
                        else{
                            break;
                        }
                    }
                    userChargingLevel::create([
                        'user_id'=>$user->id,
                        'coins'=>$new_coins,
                        'user_level'=>$new_level
                    ]);
                    $coins = $user->coins + $addedAmount;
                    $user->update(['coins' => $coins]);
                }
                $data = userChargingLevel::where('user_id',$user->id)->select('coins','user_level')->first();
                $massage = __('api.success');
                return $this->successResponse($data,$massage);

            }else{
                $massage = __('api.notSuper');
                return $this->errorResponse($massage, []);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage, []);
        }
    }

    public function reduceUserGems(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if ($admin->super == 1) {
                $rules =  [
                    'user_unique_id'  => 'required',
                    'amount' => 'required'
                ];
                $validator = Validator::make(request()->all(), $rules);
                $errors = $this->formatErrors($validator->errors());
                if($validator->fails()) {
                    log::debug('error message '.$errors);
                    return $this->errorResponse($errors,[]);
                }
                $user_unique_id = $request->input('user_unique_id');
                $reducedAmount = $request->input('amount');
                $userGems = User::where('special_id', $user_unique_id)->pluck('gems')->first();
                if($userGems === null){
                    $massage = __('api.userNotFound');
                    return $this->errorResponse($massage, []);
                }
                $newGems = $userGems - $reducedAmount;
                $user = User::where('special_id', $user_unique_id)->update(['gems' => $newGems]);
                $massage = __('api.success');
                return $this->successResponse([], $massage);
            }else{
                $massage = __('api.notSuper');
                return $this->errorResponse($massage, []);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage, []);
        }
    }
    public function reduceUserCoins(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if ($admin->super == 1) {
                $rules =  [
                    'user_unique_id'  => 'required',
                    'amount' => 'required'
                ];
                $validator = Validator::make(request()->all(), $rules);
                $errors = $this->formatErrors($validator->errors());
                if($validator->fails()) {
                    log::debug('error message '.$errors);
                    return $this->errorResponse($errors,[]);
                }
                $user_unique_id = $request->input('user_unique_id');
                $reducedAmount = $request->input('amount');
                $userCoins = User::where('special_id', $user_unique_id)->pluck('coins')->first();
                if($userCoins === null){
                    $massage = __('api.userNotFound');
                    return $this->errorResponse($massage, []);
                }
                $newcoins = $userCoins - $reducedAmount;
                $user = User::where('special_id', $user_unique_id)->update(['coins' => $newcoins]);
                $massage = __('api.success');
                return $this->successResponse([], $massage);
            }else{
                $massage = __('api.notSuper');
                return $this->errorResponse($massage, []);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage, []);
        }
    }
}
