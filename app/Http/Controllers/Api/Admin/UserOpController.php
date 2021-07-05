<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

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
}
