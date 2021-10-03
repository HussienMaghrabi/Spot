<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomMember;
use Illuminate\Http\Request;

class RoomPrivileges extends Controller
{
    // check room owner
    public function check_room_owner($user_id, $room_id){

        $roomOwner = Room::where('id', $room_id)->select('room_owner')->first();
        if($user_id == $roomOwner->room_owner){
            return true;
        }
        else{
            return false;
        }

    }

    // check room admin
    public function check_room_admin($user_id, $room_id){
        $admins = RoomMember::where('room_id', $room_id)->pluck('admins')->toArray();
        $returnObj['admins'] = $admins[0];
        $it = 0;
        foreach ($admins[0] as $admin){
            if($admin == $user_id){
                $returnObj['status'] = true;
                $returnObj['location'] = $it;
                return $returnObj;
            }
            $it++;
        }
        $returnObj['status'] = false;
        return $returnObj;
    }

    // check room member
    public function check_room_member($user_id, $room_id){
        $members = RoomMember::where('room_id', $room_id)->pluck('join_user')->toArray();
        $returnObj['members'] = $members[0];
        $it = 0;
        foreach ($members[0] as $user){
            if($user == $user_id){
                $returnObj['status'] = true;
                $returnObj['location'] = $it;
                return $returnObj;
            }
            $it++;
        }
        $returnObj['status'] = false;
        return $returnObj;
    }

}
