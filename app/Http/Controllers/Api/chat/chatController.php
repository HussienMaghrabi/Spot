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
        ->leftJoin('users as user_to','messages.user_to','=','user_to.id')
        ->leftJoin('users as user_from','messages.user_from','=','user_from.id')
        ->select('messages.id as id','messages.message','user_to.id as recever_id','user_to.name as recever_name','user_to.profile_pic as recever_pic','user_from.id as sender_id','user_from.name as sender_name','user_from.profile_pic as sender_pic','messages.created_at as message_time')
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
        ->select('messages.id as id','messages.user_to','messages.message as message','users.id as user_id','users.profile_pic as image','messages.created_at as message_time')
        ->where('messages.user_from',$this->auth())
        ->groupBy('messages.user_to')
        ->take(5)
        ->orderBy("messages.id","desc")
        ->get();
        // return $this->successResponse($this->conversionCollection($sql));
        return $this->successResponse($sql);
    }
}
