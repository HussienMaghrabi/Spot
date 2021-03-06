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

        // check if mic is locked, taken or free
        $adminMuted = -1;
        $iterator = 0;
        foreach ($data[0] as $mics){

            $itMic = explode(',', $mics);
            $micUser = (int)$itMic[0];
            $micUserMute = (int)$itMic[1];
            $micLocation = (int)$itMic[2];
            $adminMuted = (int)$itMic[3];
            $adminLocked = (int)$itMic[4];
            if($micLocation == $location){
                // check if mic locked
                if($adminLocked == 1){
                    // return error response with mic locked msg
                    $message = __('api.micLocked'); // add this msg
                    return $this->errorResponse($message, []);
                }
                // check if mic taken
                elseif($micUser != 0){
                    // return error response with ic taken msg
                    $message = __('api.micTaken'); // add this msg
                    return $this->errorResponse($message, []);
                }
                // user can take this mic
                else{
                    // check if user already exists on other mic
                    $mute = 0;
                    foreach ($data[0] as $user1){
                        $tmpArray = explode(',', $user1);
                        $user_id = (int)$tmpArray[0];
                        $mute = (int)$tmpArray[1];
                        $oldLocation = (int)$tmpArray[2];
                        $oldAdminMuted = (int)$tmpArray[3];
                        $oldAdminlocked = 0;
                        // change location
                        if($auth == $user_id){
                            dd('old mic');
                            array_splice($data[0],$it, 1);
                            if($oldAdminMuted == 1){
                                $input.= 0 . ',' . 0 . ',' . $oldLocation .','. $oldAdminMuted . ',' . $oldAdminlocked ;
                                array_push($data[0], $input);
                                $done = true;
                                break;
                            }
                        }
                        $it++;
                    }
                    array_splice($data[0],$iterator, 1);
                    $input.= $auth . ',' . $mute . ',' . $location .','. $adminMuted . ',' . 0 ;
                    array_push($data[0], $input);
                    RoomMember::where('room_id', $room_id)->update(['on_mic'=>$data[0]]);
                    $message = __('api.success');
                    return $this->successResponse([], $message);
                }
            }
            $iterator++;
        }
        if($adminMuted == -1){
            $adminMuted = 0;
        }
        $adminLocked = 0;

        // check if user already exists
        foreach ($data[0] as $user1){
            $tmpArray = explode(',', $user1);
            $user_id = (int)$tmpArray[0];
            $mute = (int)$tmpArray[1];
            $currLocation = (int)$tmpArray[2];
            $currAdminMute = (int)$tmpArray[3];
            $currAdminLocked = 0;
            // change location
            if($auth == $user_id){
                array_splice($data[0],$it, 1);
                if($currAdminMute == 1){
                    $input = 0 . ',' . 0 . ',' . $currLocation .','. $currAdminMute . ',' . $currAdminLocked ;
                    array_push($data[0], $input);
                }

                $input = $user_id . ',' . $mute . ',' . $location .','. 0 . ',' . 0;
                array_push($data[0], $input);
                $done = true;
                break;
            }
            $it++;
        }
        // if user doesn't exist, add user to array
        if(!$done){
            // add user to array and update it
            $input.= $auth . ',' . 0 . ',' . $location.','. 0 . ',' . 0 ;
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
                    $adminMuted = (int)$tmpArray[3];
                    // if mic was already admin muted
                    if($adminMuted == 1){

                        $location = (int)$tmpArray[2];
                        $input = 0 .','. 0 .','. $location.','. $adminMuted .','. 0;
                        array_push($data[0], $input);

                    }
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
            // to be added ------>
            // check if owner or admin instead of owner only
            // if owner, he can kick all, else if admin, he can kick members only
            // check with roomPrivilege object

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
            if($user['user_id'] != 0){

                $collection = User::where('id', $user['user_id'])->select('name', 'profile_pic as image')->first();
                $user['name']=$collection->name;
                $user['image']=$collection->image;
            }else{
                $user['name']="";
                $user['image']="";
            }
            $mute = (int)$tmpArray[1];
            if($mute){
                $user['mute'] = true;
            }else{
                $user['mute'] = false;
            }
            $user['location'] = (int)$tmpArray[2];
            $admin_mute = (int)$tmpArray[3];
            if($admin_mute){
                $user['admin_mute'] = true;
            }else{
                $user['admin_mute'] = false;
            }
            $admin_lock = (int)$tmpArray[4];
            if($admin_lock){
                $user['$admin_lock'] = true;
            }else{
                $user['$admin_lock'] = false;
            }
            $checkObj = new RoomPrivileges();
            $checkValue = $checkObj->check_room_admin((int)$tmpArray[0], $room_id);
            $user['is_admin'] = $checkValue['status'];
            $checkValue = $checkObj->check_room_member((int)$tmpArray[0], $room_id);
            $user['is_member'] = $checkValue['status'];
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

                    }elseif ($user_id == 0){
                        $input.= 0 . ',' . 0 . ',' . $targetLocation . ',' . 0 . ',' . 1;
                        $item = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
                        array_push($item[0], $input);
                        RoomMember::where('room_id',$room_id)->update(['on_mic'=>$item[0]]);
                        $done = true;
                        return $this->successResponse([],__('api.success'));
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

    public function unlock_mic(Request $request)
    {
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
            $it = 0;
            foreach ($data[0] as $user1) {
                $tmpArray = explode(',', $user1);
                $user_id = (int)$tmpArray[0];
                $request['user_id'] = $user_id;
                $micLocation = (int)$tmpArray[2];
                $lock = (int)$tmpArray[4];
                if ($micLocation == $targetLocation){
                    if($lock == 0){
                        $message = __('api.alreadyNotLocked');
                        return $this->errorResponse($message, []);
                    }else{
                        array_splice($data[0],$it, 1);
                        RoomMember::where('room_id',$room_id)->update(['on_mic'=>$data[0]]);
                        $done = true;
                        return $this->successResponse([],__('api.success'));
                    }
                }$it++;
            }
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

                    }elseif ($user_id == 0){
                        array_splice($data[0],$it, 1);
                        $input.= 0 . ',' . 0 . ',' . $targetLocation . ',' . 1 . ',' . 0;
                        array_push($data[0], $input);
                        RoomMember::where('room_id',$room_id)->update(['on_mic'=>$data[0]]);
                        $done = true;
                        return $this->successResponse([],__('api.success'));
                    }
                }
                $it++;
            } // end foreach
            if(!$done)
            {
                $input.= 0 . ',' . 0 . ',' . $targetLocation . ',' . 1 . ',' . 0;
                $item = RoomMember::where('room_id', $room_id)->pluck('on_mic')->toArray();
                array_push($item[0], $input);
                RoomMember::where('room_id',$room_id)->update(['on_mic'=>$item[0]]);
                return $this->successResponse([],__('api.success'));
            }
        }else{
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }

    }


    public function unmute_mic(Request $request){
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
                    if($AdminMute == 0){
                        $message = __('api.alreadyNotMute');
                        return $this->errorResponse($message, []);
                    }elseif ($user_id != 0){
                        if ($adminOnMic == true){
                            if ($owner == true){
                                array_splice($data[0],$it, 1);
                                $input.= $user_id . ',' . $userMute . ',' . $targetLocation . ',' . 0 . ',' . 0;
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
                            $input.= $user_id . ',' . $userMute . ',' . $targetLocation . ',' . 0 . ',' . 0;
                            array_push($data[0], $input);
                            RoomMember::where('room_id',$room_id)->update(['on_mic'=>$data[0]]);
                            $done = true;
                            return $this->successResponse([],__('api.success'));
                        }

                    }elseif ($user_id == 0){
                        array_splice($data[0],$it, 1);
                        $input.= 0 . ',' . 0 . ',' . $targetLocation . ',' . 0 . ',' . 0;
                        array_push($data[0], $input);
                        RoomMember::where('room_id',$room_id)->update(['on_mic'=>$data[0]]);
                        $done = true;
                        return $this->successResponse([],__('api.success'));
                    }
                }
                $it++;
            } // end foreach
            if(!$done)
            {
                $input.= 0 . ',' . 0 . ',' . $targetLocation . ',' . 0 . ',' . 0;
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
