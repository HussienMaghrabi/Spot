<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Follow_relation;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function following()
    {
        //
        $auth = $this->auth();
        $array = Follow_relation::where('user_1', $auth)->pluck('user_2')->toArray();
        $data = User::whereIn('id', $array)->select('id','name','profile_pic')->get();
        return $this->successResponse($data);


    }

    // return count of followed users by single user
    public function followingCount()
    {
        $auth = $this->auth();
        $array = Follow_relation::where('user_1', $auth)->pluck('user_2')->toArray();
        $count = count($array);
        return $this->successResponse($count);
    }

    // follow a user
    public function follow(Request $request)
    {
        $auth = $this->auth();
        $id = $request->input('user_2');
        $query = Follow_relation::where('user_2' , $id)->where('user_1' , $auth)->pluck('id');
        $count = count($query);
        if($count == 0) {
            $rules = [
                'user_2' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $input = $request->all();

            $input['user_1'] = $auth;
            $data['followed-user'] = Follow_relation::create($input);
            $message = __('followed user');
            return $this->successResponse($data, $message);
        }else{
            $message = __('already followed user');
            return $this->successResponse($message);
        }
    }

    // unfollow a user
    public function unfollow(Request $request)
    {
        $auth = $this->auth();
        $id = $request->input('user_2');
        $query = Follow_relation::where('user_2' , $id)->where('user_1' , $auth)->pluck('id');
        $count = count($query);
        if($count == 0) {

            $message = __('you are not following this user');
            return $this->successResponse($message);


        }else{
            $rules = [
                'user_2' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $target = $query[0];
            $sql = Follow_relation::where('id' ,$target)->first();
            if($sql) {
                $message = __('unfollowed user');
                $sql->delete();
                return $this->successResponse(null, $message);

            }

            $input['user_1'] = $auth;
            $data['followed-user'] = Follow_relation::create($input);
            $message = __('followed user');
            return $this->successResponse($data, $message);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function followers()
    {
        $auth = $this->auth();
        $array = Follow_relation::where('user_2', $auth)->pluck('user_1')->toArray();
        $data = User::whereIn('id', $array)->select('id','name','profile_pic')->get();
        return $this->successResponse($data);
    }

    // return count of followers for single user
    public function followersCount()
    {
        $auth = $this->auth();
        $array = Follow_relation::where('user_2', $auth)->pluck('user_1')->toArray();
        $count = count($array);
        return $this->successResponse($count);
    }
}
