<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\levels\DailyExpController;
use App\Http\Controllers\Api\levels\levelController;
use App\Models\Follow_relation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $data = User::whereIn('id', $array)->select('id','name','profile_pic as image')->paginate(15);
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

            // adding exp to user for following a user
            $dailyExpController = new DailyExpController();
            $value = $dailyExpController->checkFollowExp();
            $LevelController = new levelController();
            $LevelController->addUserExp($value, $auth);

            $message = __('api.followed');
            return $this->successResponse($data, $message);
        }else{
            $message = __('api.already_followed');
            return $this->errorResponse($message,[]);
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

            $message = __('api.not_follow');
            return $this->errorResponse($message,[]);


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
                $message = __('api.unfollowed');
                $sql->delete();
                return $this->successResponse([], $message);

            }
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
        $data = User::whereIn('id', $array)->select('id','name','profile_pic as image')->paginate(15);
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
