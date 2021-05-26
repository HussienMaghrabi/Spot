<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Admin::orderBy('id', 'DESC')->select('id','name','email')->get();
        return $this->successResponse($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:admins|unique:users',
            'password' => 'min:6',
        ];

        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $token = Str::random(70);
        $input = $request->except('profile_pic');
        if( $request->profile_pic) {
            $input['profile_pic'] = $this->uploadFile(request('profile_pic'), 'admins');
        }
        $input['api_token'] = $token;
        Admin::create($input);
        $massage = __('api.created');
        return $this->successResponse(null,$massage);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Admin::where('id', $id)->select('id','name','email')->first();
        return $this->successResponse($data);

    }

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
            if (Auth::guard('apiAdmin')->attempt(['email' => request('email'), 'password' => request('password')]))
            {
                $auth = Auth::guard('apiAdmin')->user();
                $token = Str::random(70);
                Admin::where('id',$auth)->update(['api_token'=>$token]);
                $data['api_token'] = $token;


                return $this->successResponse($data,  __('api.RegisterSuccess'));
            }
            return $this->errorResponse(__('api.LoginFail'),null);

    }


    public function logout()
    {
        $this->lang();
        $adminAuth =  Admin::where('api_token', request()->header('Authorization'))->first();
        $auth = $adminAuth->id;
        Admin::Where('id',$auth)->update(['api_token' => null ]);

        return $this->successResponse(null, __('api.Logout'));
    }

    public function check()
    {
        $data = Admin::where('api_token', request()->header('Authorization'))->first();
        if($data)
        {
            return $this->successResponse(null,TRUE);
        }else{
            return $this->errorResponse(FALSE);
        }

    }

    public function profile()
    {
        $adminAuth =  Admin::where('api_token', request()->header('Authorization'))->first();
        $auth = $adminAuth->id;
        $data = Admin::where('id', $auth)->select(
            'id',
            'name',
            'profile_pic',
            'email'
        )->first();
        return $this->successResponse($data);
    }

    public function changePassword()
    {
        $rules =  [
            'password'  => 'required',
            'new_password'  => 'required'
        ];

        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $adminAuth =  Admin::where('api_token', request()->header('Authorization'))->first();
        $auth = $adminAuth->id;
        if (Hash::check(request('password') ,$adminAuth->password))
        {
            $pass = Admin::where('id', $auth)->first();
            $pass->update(['password' => request('new_password')]);
            return $this->successResponse(null, __('api.PasswordReset'));
        }


        return $this->errorResponse(__('api.passwordInvalid'));
    }



}
