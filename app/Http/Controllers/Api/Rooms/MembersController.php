<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\RoomMember;
use App\Models\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function room_followers(Request $request){
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('follow_user')->toArray();
        if($query[0] == null){
            $message = __('api.room_no_follow');
            return $this->errorResponse($message);
        }
        $result = User::whereIn('id', $query[0])->select('id','name','profile_pic as image')->paginate(15);
        return $this->successResponse($result);
    }

    public function follow_room(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('follow_user')->toArray();
        if($query[0] == null){
            $array[] = (string)$auth;
            RoomMember::where('room_id', $room_id)->update(['follow_user' => $array ]);
            $message = __('api.room_followed_success');
            return $this->successResponse(null, $message);
        }
        $exist = in_array((string)$auth, $query[0]);
        if($exist){
            $message = __('api.room_already_followed');
            return $this->errorResponse($message);
        }else{
            array_push($query[0], (string)$auth);
            RoomMember::where('room_id', $room_id)->update(['follow_user' => $query[0] ]);
            $message = __('api.room_followed_success');
            return $this->successResponse(null, $message);
        }
    }

    public function unFollow_room(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('follow_user')->toArray();
        if($query[0] == null){
            $message = __('api.room_not_followed');
            return $this->successResponse(null, $message);
        }
        $index = array_search((string)$auth, $query[0]);
        if ($index === false){
            $message = __('api.room_not_followed');
            return $this->errorResponse($message);
        }else{
            $result = array_splice($query[0], $index, 1);
            RoomMember::where('room_id', $room_id)->update(['follow_user' => $query[0] ]);
            $message = __('api.room_unfollowed_success');
            return $this->successResponse(null, $message);
        }
    }

    public function room_joiners(Request $request){
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('join_user')->toArray();
        if($query[0] == null){
            $message = __('api.room_no_active');
            return $this->errorResponse($message);
        }
        $result = User::whereIn('id', $query[0])->select('id','name','profile_pic as image')->paginate(15);
        return $this->successResponse($result);
    }

    public function join_room(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('join_user')->toArray();
        if($query[0] == null){
            $array[] = (string)$auth;
            RoomMember::where('room_id', $room_id)->update(['join_user' => $array ]);
            $message = __('api.room_joined_success');
            return $this->successResponse(null, $message);
        }
        $exist = in_array((string)$auth, $query[0]);
        if($exist){
            $message = __('api.room_already_joined');
            return $this->errorResponse($message);
        }else{
            array_push($query[0], (string)$auth);
            RoomMember::where('room_id', $room_id)->update(['join_user' => $query[0] ]);
            $message = __('api.room_joined_success');
            return $this->successResponse(null, $message);
        }
    }

    public function leave_room(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('join_user')->toArray();
        if($query[0] == null){
            $message = __('api.room_not_joined');
            return $this->successResponse(null, $message);
        }
        $index = array_search((string)$auth, $query[0]);
        if ($index === false){
            $message = __('api.room_not_joined');
            return $this->errorResponse($message);
        }else{
            $result = array_splice($query[0], $index, 1);
            RoomMember::where('room_id', $room_id)->update(['join_user' => $query[0] ]);
            $message = __('api.room_unjoined');
            return $this->successResponse(null, $message);
        }
    }


}
