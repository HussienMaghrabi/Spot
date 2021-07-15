<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\chargingLevel;
use App\Models\userChargingLevel;
use App\Services\PayUService\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class chargeController extends Controller
{
    public function chargIng(Request $request)
    {
        $userChargingLevel = new userChargingLevel;

        $rules =  [
            'user_id' => 'required|exists:users,id',
            'coins' => 'required',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        DB::beginTransaction();
        $data = [];
        $massage = '';
        try{
            $uObj = new userChargingLevel;
            $uObj = $uObj->where('user_id',$request->input('user_id'))->first();
            $after_per = $request->input('coins') * 100;
            // $after_per = ($request->input('coins') * 100) + ($request->input('earning') * 10 / 100);
            $data['user_id'] = $request->input('user_id');
            $data['earning'] = ($uObj) ? $uObj->earning + $after_per : $after_per;
            $data['coins'] = ($uObj) ? $uObj->coins + $request->input('coins') : $request->input('coins');
            if (!$uObj) {
                $ins = userChargingLevel::create($data);
                $uObj = $ins;
            }else{
                $ins = $uObj->update($data);
            }
            if(!$ins){
                $massage = __('api.chargeintrnalError');
                return $this->errorResponse($uObj,$massage);
            }else{
                $this->gradeUserLevel($uObj);
                DB::commit();
                $massage = __('api.chargeSuccessfull');
                return $this->successResponse($uObj,$massage);
            }
            }catch(\Exception $e){
                DB::rollback();
                throw $e;
        }
    }

    public function gradeUserLevel($userObj)
    {
        // here will create a grade level buy charching 
        // return true; // this retun just for complelte insert
        // get total earning
        $total = $userObj->earning;
        $user = [];
        foreach (chargingLevel::all() as $key => $value) {
            if ($total >= $value->level_limit) {
                userChargingLevel::where('user_id',$userObj->user_id)->update(['user_level' => $value->id]);
            }else {
                break;
            }
        }
        return (Object) $user;
    }
}
