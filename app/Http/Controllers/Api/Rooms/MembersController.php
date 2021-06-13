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
        $query = RoomMember::where('room_id' , $room_id)->pluck('follow_user');
        $result = User::whereIn('id', $query[0])->select('id','name','profile_pic')->paginate(15);
        return $this->successResponse($result, "test");
    }

    public function follow_room(Request $request){
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('follow_user');

    }


}
