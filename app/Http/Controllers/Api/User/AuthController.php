<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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
        $check = User::where('email',request('email'))->pluck('verify')->first();

        if($check == 1){
            if (Auth::guard('apiUser')->attempt(['email' => request('email'), 'password' => request('password')]))
            {
                $auth = Auth::guard('apiUser')->user();
                $token = Str::random(70);
                User::where('id',$auth->id)->update(['api_token'=>$token]);
                $data['api_token'] = $token;


                return $this->successResponse($data,  __('api.RegisterSuccess'));
            }
            return $this->errorResponse(__('api.LoginFail'),null);
        }else{
            return $this->errorResponse(__('api.notVerify'),null);
        }

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
            $input['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users');
        }
        $token = Str::random(70);
        $input['api_token'] = $token;
        $input['code'] = rand(1111, 9999);
        $input['verify'] = 0;
        $user =User::create($input);

        Mail::to($user)->send(new SendMail($user));

        return $this->successResponse(null, __('api.checkMail'));
    }

    public function confirmCode(Request $request)
    {
        $rules =  [
            'email' => 'required',
            'code' => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $user = User::where('email', $request->email)->first();

        if($user->code == $request->code){
            User::where('email',$request->email)->update(['verify'=>1, 'code' => null]);
            $data = $user::select('id', 'name', 'profile_pic', 'email','api_token')->first();
            return $this->successResponse($data, __('api.Activate'));
        } else{
            return $this->errorResponse(__('api.PromoFail'));
        }
    }

    public function social(){
        $rules =  [
            'email'  => 'required',
        ];
        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $data = User::where('email',request('email'))->first();
        if ($data)
        {
            $auth = $data->id;
            $token = Str::random(70);
            User::where('id',$auth)->update(['api_token'=>$token]);
            $items = User::where('id', $auth)->select('api_token')->first();


            return $this->successResponse($items,  __('api.RegisterSuccess'));
        }
        return $this->errorResponse(__('api.LoginFail'),null);
    }

    public function logout()
    {
        $this->lang();
        $auth = $this->auth();
        User::Where('id',$auth)->update(['api_token' => null ]);

        return $this->successResponse(null, __('api.Logout'));
    }
}
