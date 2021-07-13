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
        // get user convesation
        $data = array();
        $messages = new messages;
        // get all messages from user and groupby user_from
        $messages = $messages->with('user_to');
        $messages = $messages->where('user_from',$this->auth());
        // $messages = $messages->groupBy('user_from');
        $messages = $messages->get();
        return $this->successResponse($messages);
    }
}
