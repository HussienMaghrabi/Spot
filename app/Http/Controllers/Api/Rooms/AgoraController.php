<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomMember;
use App\Models\User;
use App\Models\UserDailyLimitExp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgoraController extends Controller
{
    // insert user id in on_mic array
    public function takeMic(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $location = $request->input('location');
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        if($data[0] == null){
            RoomMember::where('room_id', $room_id)->update(['on_mic'=>[]]);
        }
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        $done = false;
        $input = "";
        $it = 0;
        foreach ($data[0] as $user1){
            $tmpArray = explode(',', $user1);
            $user_id = (int)$tmpArray[0];
            $mute = (int)$tmpArray[1];
            if($auth == $user_id){
                array_splice($data[0],$it, 1);
                $input.= $user_id . ',' . $mute . ',' . $location;
                array_push($data[0], $input);
                $done = true;
                break;
            }
            $it++;
        }
        if(!$done){
            // add user to array and update it
            $input.= $auth . ',' . 0 . ',' . $location;
            array_push($data[0], $input);
            $now = Carbon::now()->format('H:i');
            $userDailyLimitExpObj = UserDailyLimitExp::where('user_id', $auth)->first();
            $userDailyLimitExpObj->update([
                'mic_start'=>$now
            ]);
        }
        RoomMember::where('room_id', $room_id)->update(['on_mic'=>$data[0]]);
        $message = __('api.success');
        return $this->successResponse([], $message);
    }
    // remove user id from on_mic array
    public function leaveMic(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $user_id = $request->input('user_id');
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        // user will leave mic
        if($auth == $user_id){
            $it = 0;
            foreach ($data[0] as $user1) {
                $tmpArray = explode(',', $user1);
                $record_user_id = (int)$tmpArray[0];
                if($auth === $record_user_id){
                    array_splice($data[0],$it, 1);
                    RoomMember::where('room_id', $room_id)->update(['on_mic'=>$data[0]]);
                    break;
                }
                $it++;
            }
            $message = __('api.success');
            return $this->successResponse([], $message);
        }
        // admin will kick user from mic
        else{
            $room_owner = Room::where('id', $room_id)->pluck('room_owner')->first();
            if($auth == $room_owner){
                $it = 0;
                foreach ($data[0] as $user1) {
                    $tmpArray = explode(',', $user1);
                    $record_user_id = (int)$tmpArray[0];
                    if($user_id === $record_user_id){
                        array_splice($data[0],$it, 1);
                        RoomMember::where('room_id', $room_id)->update(['on_mic'=>$data[0]]);
                        break;
                    }
                    $it++;
                }
                $message = __('api.success');
                return $this->successResponse([], $message);
            }
            else{
                $message = __('api.Unauthorized');
                return $this->errorResponse($message, []);
            }
        }
    }
    // identify that user is muted
    public function mute(Request $request){
        $room_id = $request->input('room_id');
        $auth = $this->auth();
        $user_id = $request->input('user_id');
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        if($data[0] == null){
            RoomMember::where('room_id', $room_id)->update(['on_mic'=>[]]);
        }
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        $input = "";
        // user wants to mute him self
        if($auth == $user_id){
            $it = 0;
            foreach ($data[0] as $user1) {
                $tmpArray = explode(',', $user1);
                $record_user_id = (int)$tmpArray[0];
                $record_user_location = (int)$tmpArray[2];
                if($auth === $record_user_id){
                    array_splice($data[0],$it, 1);
                    $input.= $user_id . ',' . 1 . ',' . $record_user_location;
                    array_push($data[0], $input);
                    RoomMember::where('room_id', $room_id)->update(['on_mic'=>$data[0]]);
                    break;
                }
                $it++;
            }
            $message = __('api.success');
            return $this->successResponse([], $message);
        }
        // check for room admin
        else{
            // room owner
            $room_owner = Room::where('id', $room_id)->pluck('room_owner')->first();
            if($auth == $room_owner){
                $it = 0;
                foreach ($data[0] as $user1) {
                    $tmpArray = explode(',', $user1);
                    $record_user_id = (int)$tmpArray[0];
                    $record_user_location = (int)$tmpArray[2];
                    if($user_id === $record_user_id){
                        array_splice($data[0],$it, 1);
                        $input.= $user_id . ',' . 1 . ',' . $record_user_location;
                        array_push($data[0], $input);
                        RoomMember::where('room_id', $room_id)->update(['on_mic'=>$data[0]]);
                        break;
                    }
                    $it++;
                }
                $message = __('api.success');
                return $this->successResponse([], $message);
            }
            // not room owner
            else{
                $message = __('api.Unauthorized');
                return $this->errorResponse($message, []);
            }
        }

    }
    // identify that user is un-muted
    public function unMute(Request $request){
        $room_id = $request->input('room_id');
        $auth = $this->auth();
        $user_id = $request->input('user_id');
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        if($data[0] == null){
            RoomMember::where('room_id', $room_id)->update(['on_mic'=>[]]);
        }
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        $input = "";
        // user wants to mute him self
        if($auth == $user_id){
            $it = 0;
            foreach ($data[0] as $user1) {
                $tmpArray = explode(',', $user1);
                $record_user_id = (int)$tmpArray[0];
                $record_user_location = (int)$tmpArray[2];
                if($auth === $record_user_id){
                    array_splice($data[0],$it, 1);
                    $input.= $user_id . ',' . 0 . ',' . $record_user_location;
                    array_push($data[0], $input);
                    RoomMember::where('room_id', $room_id)->update(['on_mic'=>$data[0]]);
                    break;
                }
                $it++;
            }
            $message = __('api.success');
            return $this->successResponse([], $message);
        }
        // check for room admin
        else{
            // room owner
            $room_owner = Room::where('id', $room_id)->pluck('room_owner')->first();
            if($auth == $room_owner){
                $it = 0;
                foreach ($data[0] as $user1) {
                    $tmpArray = explode(',', $user1);
                    $record_user_id = (int)$tmpArray[0];
                    $record_user_location = (int)$tmpArray[2];
                    if($user_id === $record_user_id){
                        array_splice($data[0],$it, 1);
                        $input.= $user_id . ',' . 0 . ',' . $record_user_location;
                        array_push($data[0], $input);
                        RoomMember::where('room_id', $room_id)->update(['on_mic'=>$data[0]]);
                        break;
                    }
                    $it++;
                }
                $message = __('api.success');
                return $this->successResponse([], $message);
            }
            // not room owner
            else{
                $message = __('api.Unauthorized');
                return $this->errorResponse($message, []);
            }
        }

    }
    // return list of users on mic
    public function mic_users(Request $request){
        $room_id = $request->input('room_id');
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        if($data[0] == null){
            RoomMember::where('room_id', $room_id)->update(['on_mic'=>[]]);
        }
        $data = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
        $finalData = [];
        foreach ($data[0] as $user1){
            $tmpArray = explode(',', $user1);

            $user['user_id'] = (int)$tmpArray[0];
            $collection = User::where('id', $user['user_id'])->select('name', 'profile_pic as image')->first();
            $user['name']=$collection->name;
            $user['image']=$collection->image;
            $mute = (int)$tmpArray[1];
            if($mute){
                $user['mute'] = true;
            }else{
                $user['mute'] = false;
            }
            $user['location'] = (int)$tmpArray[2];
            $finalData[] = $user;
        }
        $message = __('api.success');
        return $this->successResponse($finalData, $message);

    }
}
