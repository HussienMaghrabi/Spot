<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\chargingLevel;
use App\Services\PayUService\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class chargeController extends Controller
{
    public function chargIng(Request $request)
    {
        $chargingLevel = new chargingLevel;

        $rules =  [
            'user_id' => 'required|exists:users,id',
            'coins' => 'required',
            'amount' => 'required',
        ];
        $type = ($request->input('type') == 1) ? 1 : 0;
        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        DB::beginTransaction();
        try{
            $ins = chargingLevel::create([
                'user_id' => $request->input('user_id'),
                'coins' => $request->input('coins'),
                'amount' => $request->input('amount'),
                'type' => ($type == 1) ? 'valid_process' : 'invalid_process',
            ]);
            if(!$ins){
                return $this->errorResponse('not complete operation');
            }else{
                $this->gradeUserLevel($ins);
                DB::commit();
                $massage = __('api.chargeSuccessfull');
                return $this->successResponse($ins,$massage);
            }
            }catch(\Exception $e){
                DB::rollback();
                throw $e;
        }
    }

    public function gradeUserLevel($userObj)
    {
        // here will create a grade level buy charching 
        return true; // this retun just for complelte insert
    }
}
