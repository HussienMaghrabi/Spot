<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Block_relation;
use App\Models\User;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function block()
    {
        //
        $auth = $this->auth();
        $array = Block_relation::where('user_1', $auth)->pluck('user_2')->toArray();
        $data = User::whereIn('id', $array)->select('id','name','profile_pic')->get();
        return $this->successResponse($data);


    }


}
