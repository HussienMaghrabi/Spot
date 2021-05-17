<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
        $this->lang();
        $rules =  [
            'email'    => 'required',
            'password' => 'required',
        ];


        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        if (Auth::guard('apiUser')->attempt(['email' => request('email'), 'password' => request('password')]))
        {
            $auth = Auth::guard('apiUser')->user();
            $token = Str::random(70);
            User::where('id',$auth->id)->update(['api_token'=>$token]);

            $data['user'] = User::where('id', $auth->id)->select('id', 'name', 'profile_pic', 'email','api_token')->first();



            return $this->successResponse($data,  __('api.RegisterSuccess'));
        }
        return $this->errorResponse(__('api.LoginFail'),null);
    }

    public function register(Request $request)
    {
        $this->lang();
        $rules =  [
            'name'  => 'required',
            'email'  => 'required|unique:users',
            'password'  => 'required',
            'profile_pic'  => 'nullable',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $input = request()->except('profile_pic','api_token');


        if (request('profile_pic'))
        {
            $inputs['image'] =$this->uploadFile($request->image, 'category');
            $input['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users');
        }
        $token = Str::random(70);
        $input['api_token'] = $token;
        $auth = User::create($input);


        $data['user'] = User::where('id', $auth->id)->select('id', 'name', 'profile_pic', 'email','api_token')->first();

        return $this->successResponse($data, __('api.RegisterSuccess'));
    }

    public function logout()
    {
        $this->lang();
        $auth = $this->auth();
        User::find($auth)->update(['api_token' => null]);
        return $this->successResponse(null, __('api.Logout'));
    }
}
