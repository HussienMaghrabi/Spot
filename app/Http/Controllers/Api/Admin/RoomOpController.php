<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Room;
use App\Models\User;
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

    public function changeNameRoom(Request $request){
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            if ($request->has('room_id')) {
                $target_room = $request->input('room_id');
                $room = Room::where('id', $target_room)->first();
                if($room === null){
                    $massage = __('api.roomNotFound');
                    return $this->errorResponse($massage);
                }
                $name = $request->input('name');
                $room = Room::where('id', $target_room)->update(['name' => $name]);
                $massage = __('api.success');
                return $this->successResponse($room, $massage);
            } else {
                $massage = __('api.missing_room');
                return $this->errorResponse($massage);
            }
        }else{
            $massage = __('api.notAdmin');
            return $this->errorResponse($massage);
        }
    }



}
