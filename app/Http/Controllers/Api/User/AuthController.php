<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Token;
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
            Token::create(['api_token'=>$token, 'user_id' => $auth->id]);
             User::where('id', $auth->id)->first();
            $data['api_token'] = $token;


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
            $input['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users');
        }
        $token = Str::random(70);
        $auth = User::create($input);
        Token::create(['api_token' => $token, 'user_id' => $auth->id]);


        $data['user'] = User::where('id', $auth->id)->select('id', 'name', 'profile_pic', 'email')->first();
        $data['api_token'] = $token;

        return $this->successResponse($data, __('api.RegisterSuccess'));
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
            Token::create(['api_token'=>$token, 'user_id' => $auth]);

           $items = User::where('id', $auth)->select('id', 'name', 'profile_pic', 'email')->first();
           $items['api_token'] = $token;


            return $this->successResponse($items,  __('api.RegisterSuccess'));
        }
        return $this->errorResponse(__('api.LoginFail'),null);
    }

    public function logout()
    {
        $this->lang();
        $auth = request()->header('Authorization');
        Token::Where('api_token',$auth)->update(['api_token' => null ]);

        return $this->successResponse(null, __('api.Logout'));
    }
}
