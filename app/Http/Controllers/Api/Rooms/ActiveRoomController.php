<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Api\Rooms\RecentRoomController;
use App\Http\Controllers\Controller;
use App\Models\RecentRoom;
use App\Models\Room;
use App\Models\RoomMember;
use App\Models\User;
use App\Models\UserRoom;
use Illuminate\Http\Request;

class ActiveRoomController extends Controller
{
    public function enterRoom(Request $request)
    {
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $sql = UserRoom::where('user_id', $auth)->pluck('active_room');

        if($sql != null){
            $this->leave_room($request);
        }
        $var = RoomMember::where('room_id',$room_id)->first();
        if($var === null){
            RoomMember::create(['room_id' => $room_id , 'active_count'=> 0]);
        }
        $query = RoomMember::where('room_id',$room_id)->pluck('active_user')->toArray();
        $varr = UserRoom::where('user_id',$auth)->first();
        if($varr === null){
            UserRoom::create(['user_id' => $auth]);
        }
         UserRoom::where('user_id',$auth)->update(['active_room'=>$room_id]);
        $active_count = RoomMember::where('room_id',$room_id)->pluck('active_count')->first();
        if($query[0] == null){
            $array[] = (string)$auth;
            RoomMember::where('room_id', $room_id)->update(['active_user' => $array , 'active_count'=> $active_count + 1]);
            $message = __('api.room_enter_success');
            $var2 = new RecentRoomController();
            $var2->last_room($room_id);
            return $this->successResponse(null, $message);
        }
        $exist = in_array((string)$auth, $query[0]);
        if($exist){
            $var2 = new RecentRoomController();
            $var2->last_room($room_id);
            $message = __('api.room_already_enter');
            return $this->errorResponse($message);
        }else{
            $var2 = new RecentRoomController();
            $var2->last_room($room_id);
            array_push($query[0], (string)$auth);
            RoomMember::where('room_id', $room_id)->update(['active_user' => $query[0] , 'active_count'=> $active_count + 1]);
            $message = __('api.room_enter_success');
            return $this->successResponse(null, $message);
        }
    }

    public function leave_room(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('active_user')->toArray();
        if($query[0] == null){
            $message = __('api.room_not_entered');
            return $this->successResponse(null, $message);
        }
        $index = array_search((string)$auth, $query[0]);
        if ($index === false){
            $message = __('api.room_not_entered');
            return $this->errorResponse($message);
        }else{
            $count = RoomMember::where('room_id', $room_id)->pluck('active_count');
            $result = array_splice($query[0], $index, 1);
            RoomMember::where('room_id', $room_id)->update(['active_user' => $query[0] , 'active_count' => $count[0] - 1]);
            $message = __('api.leave_room');
            return $this->successResponse(null, $message);
        }
    }

    public function active_user(Request $request)
    {
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('active_user')->toArray();
        if($query[0] == null){
            $message = __('api.room_no_active');
            return $this->errorResponse($message);
        }
        $result = User::whereIn('id', $query[0])->select('id','name','profile_pic as image')->paginate(15);
        return $this->successResponse($result);
    }

    public function active_room()
    {
        $query = RoomMember::orderBy('active_count', 'DESC')->pluck('room_id')->toArray();

        if($query == null){
            $message = __('api.room_no_active');
            return $this->errorResponse($message);
        }
        $result['room'] = Room::whereIn('id', $query)->select('id','name','main_image as image' , 'agora_id')->paginate(15);
        $result['room']->map(function ($item){
            $item->active_count = $item->member->active_count;

            unset($item->member);
        });
        return $this->successResponse($result);
    }
}