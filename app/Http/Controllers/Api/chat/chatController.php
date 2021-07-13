<?php

namespace App\Http\Controllers\Api\chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\messages;

class chatController extends Controller
{
    public function connection(Request $request)
    {
        // return $this->successResponse($request->all());
    }

    public function conversion(Request $request)
    {
        $rules = [
            'user_to' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules );

        if($validator->fails())
        {
            $arrV = [];
            if($validator->fails()) {
                $arrV = [];
                foreach($validator->errors()->messages() as $k => $v){
                    foreach($v as $one){$arrV[$k] = $one;}}
                    return $this->errorResponse((object)$arrV);
                }
        }
        $auth = $this->auth();
        // get Chat
        $oldChat = DB::table('messages')
        ->where('user_to',$request->user_to)->where('user_from',$auth)
        ->paginate(25);
        return $this->successResponse($oldChat);
    }

    public function getUserConversion(Request $request)
    {
        $data = array();
        $messages = new messages;
        $sql = DB::table('messages')
        ->leftJoin('users','messages.user_to','=','users.id')
        ->select('messages.id as id','messages.user_to','messages.message as message','users.id as user_id','users.profile_pic as user_image')
        ->where('messages.user_from',$this->auth())
        ->groupBy('messages.user_to')
        ->take(5)
        ->orderBy("messages.id","desc")
        ->get();
        return $this->successResponse($sql);
    }
}
