<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
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

    public function update()
    {
        $auth = $this->auth();
        $rules =  [
            'id'    => 'required',
        ];
        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) return $this->errorResponse($errors);

        $items = Diamond::where('id',request('id'))->first();

        $data = User::where('id',$auth)->first();

        if($data->gems >= $items->req_diamond){
            $newGems = $data->gems - $items->req_diamond ;
            $newCoins = $data->coins + $items->coins ;

            $data->update([
                'gems' => $newGems ,
                'coins' => $newCoins
            ]);
            return $this->successResponse(null,__('api.success'));
        }else{
            return $this->errorResponse(__('api.notEnough'),[]);
        }
    }
}
