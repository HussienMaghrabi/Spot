<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomOpController extends Controller
{
    // pin room
    public function pinRoom(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $item = Room::find($request->input('room_id'));
            $data['pinned'] = 1;
            $item->update($data);
            return $this->successResponse(null, __('api.Updated'));
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
    }

    // up-pin room
    public function unPinRoom(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $item = Room::find($request->input('room_id'));
            $data['pinned'] = 0;
            $item->update($data);
            return $this->successResponse($data, __('api.Updated'));
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
    }



}
