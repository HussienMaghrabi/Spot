<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Api\levels\DailyExpController;
use App\Http\Controllers\Api\levels\levelController;
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

        // check if room owner allows non-members to take mic
        $checkObj = new RoomPrivileges();
        $checkMember = $checkObj->check_room_member($auth,$room_id);
        if($checkMember['status'] == false){
            $room = Room::where('id', $room_id)->select('take_mic')->first();
            if($room->take_mic == 0){
                $message = __('api.join_needed');
                return $this->errorResponse($message, []);
            }
        }

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

                    // adding exp to user for time on mic
                    $userDailyLimitExpObj = UserDailyLimitExp::where('user_id', $auth)->first();
                    $now = Carbon::now();
                    $micTimeStart = Carbon::createFromTimeString($userDailyLimitExpObj->mic_start);
                    $diff = $now->diffInMinutes($micTimeStart);
                    $dailyExpController = new DailyExpController();
                    $value = $dailyExpController->checkMicExp($diff);
                    $LevelController = new levelController();
                    $LevelController->addUserExp($value, $auth);
                    $userDailyLimitExpObj->update([
                        'mic_start'=>0
                    ]);

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

                        // adding exp to user for time on mic
                        $userDailyLimitExpObj = UserDailyLimitExp::where('user_id', $auth)->first();
                        $now = Carbon::now();
                        $micTimeStart = Carbon::createFromTimeString($userDailyLimitExpObj->mic_start);
                        $diff = $now->diffInMinutes($micTimeStart);
                        $dailyExpController = new DailyExpController();
                        $value = $dailyExpController->checkMicExp($diff);
                        $LevelController = new levelController();
                        $LevelController->addUserExp($value, $user_id);
                        $userDailyLimitExpObj->update([
                            'mic_start'=>0
                        ]);


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

    public function lock_mic(Request $request){
        $roomPrivilege = new RoomPrivileges();
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $targetLocation = $request->input('location');
        $owner = false;
        $admin = false;
        $owner = $roomPrivilege->check_room_owner($auth,$room_id);
        $checkAdmin = $roomPrivilege->check_room_admin($auth,$room_id);
        $admin = $checkAdmin['status'];
        if($owner || $admin){
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
                $request['user_id'] = $user_id;
                $micLocation = (int)$tmpArray[2];
                $mute = (int)$tmpArray[1];
                $lock = (int)$tmpArray[4];
                $checkOwnerOnMic = $roomPrivilege->check_room_owner($user_id,$room_id);
                $checkAdminOnMic = $roomPrivilege->check_room_admin($user_id,$room_id);
                $adminOnMic = $checkAdminOnMic['status'];
                if ($micLocation == $targetLocation){
                    if($lock == 1){
                        $message = __('api.alreadyLocked');
                        return $this->errorResponse($message, []);
                    }elseif ($user_id != 0){
                        if($checkOwnerOnMic == true){
                            $message = __('api.Unauthorized');
                            return $this->errorResponse($message, []);
                        }elseif ($adminOnMic == true){
                            if ($owner == true){
                                $this->leaveMic($request);
                                $input.= 0 . ',' . 0 . ',' . $targetLocation . ',' . 0 . ',' . 1;
                                $item = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
                                array_push($item[0], $input);
                                RoomMember::where('room_id',$room_id)->update(['on_mic'=>$item[0]]);
                                $done = true;
                                return $this->successResponse([],__('api.success'));
                            }else{
                                $message = __('api.Unauthorized');
                                return $this->errorResponse($message, []);
                            }
                        }else{
                            $this->leaveMic($request);
                            $input.= 0 . ',' . 0 . ',' . $targetLocation . ',' . 0 . ',' . 1;
                            $item = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
                            array_push($item[0], $input);
                            RoomMember::where('room_id',$room_id)->update(['on_mic'=>$item[0]]);
                            $done = true;
                            return $this->successResponse([],__('api.success'));
                        }

                    }
                }
            } // end foreach
            if(!$done)
            {
                $input.= 0 . ',' . 0 . ',' . $targetLocation . ',' . 0 . ',' . 1;
                $item = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
                array_push($item[0], $input);
                RoomMember::where('room_id',$room_id)->update(['on_mic'=>$item[0]]);
            }
        }else{
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }

    }

    public function mute_mic(Request $request){
        $roomPrivilege = new RoomPrivileges();
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $targetLocation = $request->input('location');
        $owner = false;
        $admin = false;
        $owner = $roomPrivilege->check_room_owner($auth,$room_id);
        $checkAdmin = $roomPrivilege->check_room_admin($auth,$room_id);
        $admin = $checkAdmin['status'];
        if($owner || $admin){
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
                $request['user_id'] = $user_id;
                $micLocation = (int)$tmpArray[2];
                $userMute = (int)$tmpArray[1];
                $AdminMute = (int)$tmpArray[3];
                $lock = (int)$tmpArray[4];
                $checkOwnerOnMic = $roomPrivilege->check_room_owner($user_id,$room_id);
                $checkAdminOnMic = $roomPrivilege->check_room_admin($user_id,$room_id);
                $adminOnMic = $checkAdminOnMic['status'];
                if ($micLocation == $targetLocation){
                    if($AdminMute == 1){
                        $message = __('api.alreadyMute');
                        return $this->errorResponse($message, []);
                    }elseif ($user_id != 0){
                        if($checkOwnerOnMic == true){
                            $message = __('api.Unauthorized');
                            return $this->errorResponse($message, []);
                        }elseif ($adminOnMic == true){
                            if ($owner == true){
                                array_splice($data[0],$it, 1);
                                $input.= $user_id . ',' . $userMute . ',' . $targetLocation . ',' . 1 . ',' . 0;
                                array_push($data[0], $input);
                                RoomMember::where('room_id',$room_id)->update(['on_mic'=>$data[0]]);
                                $done = true;
                                return $this->successResponse([],__('api.success'));
                            }else{
                                $message = __('api.Unauthorized');
                                return $this->errorResponse($message, []);
                            }
                        }else{
                            array_splice($data[0],$it, 1);
                            $input.= $user_id . ',' . $userMute . ',' . $targetLocation . ',' . 1 . ',' . 0;
                            array_push($data[0], $input);
                            RoomMember::where('room_id',$room_id)->update(['on_mic'=>$data[0]]);
                            $done = true;
                            return $this->successResponse([],__('api.success'));
                        }

                    }
                }
                $it++;
            } // end foreach
            if(!$done)
            {
                $input.= $user_id . ',' . $userMute . ',' . $targetLocation . ',' . 1 . ',' . 0;
                $item = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
                array_push($item[0], $input);
                RoomMember::where('room_id',$room_id)->update(['on_mic'=>$item[0]]);
            }
        }else{
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }

    }
}
