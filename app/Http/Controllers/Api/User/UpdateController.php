<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

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
    public function update(Request $request)
    {
        $this->lang();
        $auth = $this->auth();
        $rules =  [
            'name'    => 'required',
            'gender'  => 'required',
            'country' => 'required',
            'desc'    => 'required',
            'images.*'    => 'required|image',
            'profile_pic'  => 'nullable',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) return $this->errorResponse($errors);

        $input = request()->except('profile_pic','images');
        $item = User::find($auth);

        if (request('profile_pic'))
        {
            if (strpos($item->profile_pic, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->profile_pic);
                Storage::disk('public')->delete($image);
            }
            $input['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users'.$auth);
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                UserImage::create([
                    'image' => $this->uploadFile($image, 'users'.$auth),
                    'user_id' => $item->id
                ]);
            }
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

    public function userBadge()
    {
        $auth = $this->auth();
        if($auth){
            $rules = [
                'user_id' => 'required',
            ];

            $validator = Validator::make(request()->all(), $rules);
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $data['user'] = UserBadge::where('user_id',request('user_id'))->select('id','badge_id')->get();
            $data['user']->map(function ($item)  {
                $item->badge_name = $item->badge->name;
                $item->badge_img = $item->badge->img_link;
                $item->description = $item->badge->description;

                unset($item->badge);
                unset($item->badge_id);

            });


            return $this->successResponse($data);
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }


    }

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
