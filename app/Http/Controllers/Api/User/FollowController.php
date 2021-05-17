<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Follow_relation;
use App\Models\User;
use Illuminate\Http\Request;

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
}
