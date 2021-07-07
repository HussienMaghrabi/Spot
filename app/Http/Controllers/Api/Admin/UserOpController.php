<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserOpController extends Controller
{
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
}
