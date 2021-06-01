<?php

namespace App\Http\Controllers\Api\chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class chatController extends Controller
{
    public function connection(Request $request)
    {
        // return $this->successResponse($request->all());
    }

    public function conversion(Request $request)
    {
        // $rules = [
        //     'user_to' => 'required|exists:users,id',
        //     'message' => 'required',
        // ];

        // $validator = Validator::make($request->all(), $rules );
        
        // if($validator->fails()) 
        // {
        //     $arrV = [];
        //     if($validator->fails()) {
        //         $arrV = [];
        //         foreach($validator->errors()->messages() as $k => $v){
        //             foreach($v as $one){$arrV[$k] = $one;}}
        //             return $this->errorResponse((object)$arrV);
        //         }
        // }
        // $auth = $this->auth();
        // // insert pramters
        // $data = array();
        // DB::beginTransaction();
        // try{
        //     $data['user_from'] = $auth;
        //     $data['user_to'] = $request->user_to;
        //     $data['message'] = $request->message;
    
        //     DB::table('messages')->insert($data);
        //     DB::commit();
        //     return $this->successResponse($request->all());
        // }catch(\Exception $e)
        // {
        //     DB::rollback();
        //     return $this->errorResponse('fatal error');
        // }

        // return $this->successResponse($auth);
    }
}
