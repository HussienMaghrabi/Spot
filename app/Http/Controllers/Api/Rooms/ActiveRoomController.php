<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
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

        $khra = new HandleRoomController();
        $khra->checkBanEnter($request);
        if ($khra === true){
            $message = __('api.you_baned');
            return $this->errorResponse($message);
        }else{

            $room_id = $request->input('room_id');

            $check = $this->check_room_pass($request);
            if ($check === true){
                $sql = UserRoom::where('user_id', $auth)->pluck('active_room')->first();
                if($sql != null){
                    $request['target_room_id'] = $sql;
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
            }else{
                return $this->errorResponse(__('api.PasswordInvalid'));
            }
        }
    }

    public function check_room_pass(Request $request){
        $room_id = $request->input('room_id');
        $room_pass = Room::where('id',$room_id)->pluck('password')->first();
        if ($room_pass != null) {
            if ($request->has('password')) {
                if ($request->password != $room_pass) {
                    return $this->errorResponse(__('api.PasswordInvalid'));
                }else{
                    return true;
                }
            } else {
                return false;
            }
        }else{
            return true;
        }
    }

    public function leave_room(Request $request){
        if ($request->has('user_id')){
            $auth = $request->input('user_id');
        }else{
            $auth = $this->auth();
        }
        if($request->has('target_room_id')){
            $room_id = $request->input('target_room_id');
        }else{
            $room_id = $request->input('room_id');
        }
        $query = RoomMember::where('room_id' , $room_id)->pluck('active_user')->toArray();
        if($query[0] == null){
            $message = __('api.room_not_entered');
            return $this->successResponse(null, $message);
        }
        $index = array_search((string)$auth, $query[0]);
        if ($index === false){
            UserRoom::where('user_id' , $auth)->update(['active_room'=>0]);
            $message = __('api.room_not_entered');
            return $this->errorResponse($message);
        }else{
            $count = RoomMember::where('room_id', $room_id)->pluck('active_count');
            $result = array_splice($query[0], $index, 1);
            RoomMember::where('room_id', $room_id)->update(['active_user' => $query[0] , 'active_count' => $count[0] - 1]);
            UserRoom::where('user_id' , $auth)->update(['active_room'=>0]);
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
        $result = User::whereIn('id', $query[0])->select('id','name','profile_pic as image')->orderBy('vip_role', 'DESC')->paginate(15);
        return $this->successResponse($result);
    }

    public function active_room()
    {
        $query = RoomMember::orderBy('active_count', 'DESC')->select('room_id','active_count')->get();
        if($query == null){
            $message = __('api.room_no_active');
            return $this->errorResponse($message);
        }
        $query->map(function ($room){
           $room->id = $room->room->id;
           $room->name = $room->room->name;
           $room->agora_id = $room->room->agora_id;
           $room->image = $room->room->main_image;
            unset($room->room);

        });
        return $this->successResponse($query);
    }
}
