<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $auth = $this->auth();
        $data['user'] = User::where('id', $auth)->select(
            'id',
            'name',
            'email',
            'profile_pic',
            'curr_exp',
            'coins',
            'gems',
            'level',
            'gender',
            'country',
            'date_joined',
            'friends_num',
            'followers_num',
            'following_num'
        )->first();
        return $this->successResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['user'] = User::findOrFail($id);
        return $this->successResponse($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->lang();
        $auth = $this->auth();
        $rules =  [
            'name'    => 'required',
           // 'phone'   => 'required|unique:users,phone,'.$auth,
            'email'   => 'required|unique:users,email,'.$auth,
            'gender'  => 'required',
            'country' => 'required',
            'profile_pic'  => 'nullable',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) return $this->errorResponse($errors);

        $input = request()->except('profile_pic');
        $item = User::find($auth);

        if (request('profile_pic'))
        {
            if (strpos($item->profile_pic, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->profile_pic);
                Storage::disk('public')->delete($image);
            }
            $input['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users'.$auth);
        }
        $item->update($input);

        $data['user'] = User::where('id', $auth)->select('id', 'name', 'profile_pic',  'email')->first();
        $data['user']->api_toekn = request()->header('Authorization');

        return $this->successResponse($data, __('api.ProfileUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

//    public function updateProfile()
//    {
//
//        $auth = $this->auth();
//        $data = User::where('id', $auth)->select(
//            'id',
//            'name',
//            'profile_pic',
//            'email'
//        )->first();
//        return $this->successResponse($data);
//    }

    public function changePassword()
    {
        $auth = $this->auth();
        $rules = [
            'password' => 'required',
            'new_password' => 'required'
        ];

        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        if($auth){
            $pass = User::where('id', $auth)->first();

            if (Hash::check(request('password'), $pass->password)) {

                $pass->update(['password' => request('new_password')]);
                return $this->successResponse(null, __('api.PasswordReset'));
            }
            return $this->errorResponse(__('api.PasswordInvalid'));
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }
    }
}
