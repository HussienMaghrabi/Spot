<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Diamond;
use Illuminate\Support\Facades\Validator;

class DiamondController extends Controller
{
    public function index()
    {
        $data = Diamond::orderBy('id')->select('id','req_diamond','coins')->get();
        return $this->successResponse($data);
    }

    public function update(Request $request)
    {
        $auth = $this->auth();
        $rules =  [
            'id'    => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) return $this->errorResponse($errors);

        $items = Diamond::where('id',request('id'))->first();

        $data = User::where('id',$auth)->first();
        $request['user_id'] = $data->id;

        if($data->gems >= $items->req_diamond){
            $newGems = $data->gems - $items->req_diamond ;
            $newCoins = $data->coins + $items->coins ;

            $data->update([
                'gems' => $newGems ,
                'coins' => $newCoins
            ]);
        }
        return $this->responseUser($request);
    }

    public function responseUser(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $item = new UserResource($user);
        return $this->successResponse($item, __('api.LoginSuccess'));
    }
}
