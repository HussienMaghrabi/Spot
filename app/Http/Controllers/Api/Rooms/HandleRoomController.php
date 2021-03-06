<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HandleRoomController extends Controller
{
    public function main_image(Request $request)
    {
        $auth = $this->auth();
        $item =Room::where('room_owner',$auth)->first();

        if (strpos($item->main_image, '/uploads/') !== false) {
            $image = str_replace( asset('').'storage/', '', $item->main_image);
            Storage::disk('public')->delete($image);
        }
        $input['main_image'] = $this->uploadFile(request('image'), 'users'.$auth);

        $item->update($input);

        $items = Room::where('room_owner',$auth)->select('main_image as image')->first();
        return $this->successResponse($items);
    }

    public function background()
    {
        $auth = $this->auth();
        $item =Room::where('room_owner',$auth)->first();

        if (strpos($item->background, '/uploads/') !== false) {
            $image = str_replace( asset('').'storage/', '', $item->background);
            Storage::disk('public')->delete($image);
        }
        $input['background'] = $this->uploadFile(request('image'), 'users'.$auth);

        $date = $item->update($input);

        $items = Room::where('room_owner',$auth)->select('background as image')->first();
        return $this->successResponse($items);
    }

    public function join_fees(Request $request)
    {
        $auth = $this->auth();
        $item =Room::where('room_owner',$auth)->first();

        $input['join_fees'] = $request->join_fees;
        $item->update($input);
        $items = Room::where('room_owner',$auth)->select('join_fees')->first();
        return $this->successResponse($items);
    }

    public function send_image(Request $request)
    {
        $auth = $this->auth();
        $item =Room::where('room_owner',$auth)->first();

        if($request->send_image == 'true'){
            $item->update(['send_image'=>true]);
        }else{
            $item->update(['send_image'=>false]);
        }
        $items = Room::where('room_owner',$auth)->select('send_image')->first();
        return $this->successResponse($items);
    }

    public function take_mic(Request $request)
    {
        $auth = $this->auth();
        $item =Room::where('room_owner',$auth)->first();

        if($request->take_mic == 'true'){
            $item->update(['take_mic'=>true]);
        }else{
            $item->update(['take_mic'=>false]);
        }
        $items = Room::where('room_owner',$auth)->select('take_mic')->first();
        return $this->successResponse($items);
    }

    public function bc_message(Request $request)
    {
        $auth = $this->auth();
        $item =Room::where('room_owner',$auth)->first();
        $item->update(['broadcast_message'=> $request->bc_message]);

        $items = Room::where('room_owner',$auth)->select('broadcast_message')->first();
        return $this->successResponse($items);
    }

    public function name(Request $request)
    {
        $auth = $this->auth();
        $item =Room::where('room_owner',$auth)->first();
        $item->update(['name'=> $request->name]);

        $items = Room::where('room_owner',$auth)->select('name')->first();
        return $this->successResponse($items);
    }

    public function kickUser(Request $request)
    {
        $auth = $this->auth();
        $room = Room::where('id',$request->room_id)->first();

        if ($room->room_owner == $auth){
            $user = User::where('id',$request->user_id)->first();
            if ($user->can('can_be_kicked', Room::class)) {
                $var = new ActiveRoomController();

                return $var->leave_room($request);

           }else{
                return $this->errorResponse(__('api.no'),[]);
           }

        }else{
            return $this->errorResponse(__('api.Unauthorized'),[]);
        }

    }

    public function banEnter(Request $request)
    {
        $auth = $this->auth();
        $room = Room::where('id',$request->room_id)->first();
        $room_id = $request->room_id;
        $user_id = $request->user_id;
        $query = RoomMember::where('room_id',$room_id)->pluck('ban_enter')->toArray();

        if ($room->room_owner == $auth){
            $this->kickUser($request);
            $var = new MembersController();
            $var->unFollow_room($request);
            $var->leave_room($request);
            if($query[0] == null){
                $array[] = (string)$user_id;
                RoomMember::where('room_id', $room_id)->update(['ban_enter' => $array ]);
                $message = __("api.user_banned");
                return $this->successResponse([], $message);
            }
            $exist = in_array((string)$user_id, $query[0]);
            if($exist){
                $message = __('api.already_banned_user');
                return $this->errorResponse($message,[]);
            }else{
                array_push($query[0], (string)$user_id);
                RoomMember::where('room_id', $room_id)->update(['ban_enter' => $query[0] ]);
                $message = __('api.user_banned');
                return $this->successResponse(null, $message);
            }
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }
    }

    public function unBanEnter(Request $request){
        $auth = $this->auth();
        $room = Room::where('id',$request->room_id)->first();
        $user_id = $request->input('user_id');
        $room_id = $request->room_id;
        $query = RoomMember::where('room_id' , $room_id)->pluck('ban_enter')->toArray();

        if ($room->room_owner == $auth){

            $index = array_search((string)$user_id, $query[0]);
            if ($index === false){
                $message = __('api.user_not_baned');
                return $this->errorResponse($message);
            }else{
                $result = array_splice($query[0], $index, 1);
                RoomMember::where('room_id', $room_id)->update(['ban_enter' => $query[0] ]);
                $message = __('api.user_unbaned');
                return $this->successResponse(null, $message);
            }
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }

    }

    public function checkBanEnter(Request $request){
        $room_id = $request->room_id;
        $auth = $this->auth();
        $query = RoomMember::where('room_id',$room_id)->pluck('ban_enter')->toArray();
        if ($query[0] != null){
            $exist = in_array((string)$auth, $query[0]);
            if($exist){

                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function banChat(Request $request)
    {
        $auth = $this->auth();
        $room = Room::where('id',$request->room_id)->first();
        $room_id = $request->room_id;
        $user_id = $request->user_id;
        $query = RoomMember::where('room_id',$room_id)->pluck('ban_chat')->toArray();
        if ($room->room_owner == $auth){
            $user = User::where('id',$request->user_id)->first();
            if ($user->can('can_be_banned_write', Room::class)) {
                if ($query[0] == null) {
                    $array[] = (string)$user_id;
                    RoomMember::where('room_id', $room_id)->update(['ban_chat' => $array]);
                    $message = __('api.user_baned_success');
                    return $this->successResponse(null, $message);

                }
                $exist = in_array((string)$user_id, $query[0]);
                if ($exist) {
                    $message = __('api.user_already_baned');
                    return $this->errorResponse($message);
                } else {
                    array_push($query[0], (string)$user_id);
                    RoomMember::where('room_id', $room_id)->update(['ban_chat' => $query[0]]);
                    $message = __('api.user_baned_success');
                    return $this->successResponse(null, $message);

                }
            }else{
                return $this->errorResponse(__('api.no'));
            }
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }
    }

    public function unbanChat(Request $request){
        $auth = $this->auth();
        $room = Room::where('id',$request->room_id)->first();
        $user_id = $request->input('user_id');
        $room_id = $request->room_id;
        $query = RoomMember::where('room_id' , $room_id)->pluck('ban_chat')->toArray();

        if ($room->room_owner == $auth){

            $index = array_search((string)$user_id, $query[0]);
            if ($index === false){
                $message = __('api.user_not_baned');
                return $this->errorResponse($message);
            }else{
                $result = array_splice($query[0], $index, 1);
                RoomMember::where('room_id', $room_id)->update(['ban_chat' => $query[0] ]);
                $message = __('api.user_unbaned');
                return $this->successResponse(null, $message);
            }
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }

    }

    public function checkBanChat(Request $request){
        $room_id = $request->room_id;
        $auth = $this->auth();
        $query = RoomMember::where('room_id',$room_id)->pluck('ban_chat')->toArray();
        if ($query[0] != null){
            $exist = in_array((string)$auth, $query[0]);
            if($exist){

                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function make_room_admin(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $target_user_id = $request->input('user_id');
        // check room owner
        $checkObj = new RoomPrivileges();
        $checkOwner = $checkObj->check_room_owner($auth,$room_id);
        if($checkOwner){
            // check if admin
            $checkAdmin = $checkObj->check_room_admin($target_user_id,$room_id);
            if($checkAdmin['status'] === true){
                $message = __('api.already_admin');
                return $this->successResponse([], $message);
            }
            else{
                // add user id to array
                // return success message
                array_push($checkAdmin['admins'], $target_user_id);
                RoomMember::where('room_id', $room_id)->update(['admins'=>$checkAdmin['admins']]);
                $message['auth'] = __('api.admin_added');
                $target_user = $this->userObj($target_user_id);
                $userName = $target_user->name;
                $message['socket_status'] = "Add admin";
                $message['socket_name'] =  $userName;
                return $this->successResponse([], $message);
            }
        }
        else{
            // not authorized message and return false
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }

    }

    public function remove_room_admin(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $target_user_id = $request->input('user_id');
        // check room owner
        $checkObj = new RoomPrivileges();
        $checkOwner = $checkObj->check_room_owner($auth,$room_id);
        if($checkOwner){
            // check if admin
            $checkAdmin = $checkObj->check_room_admin($target_user_id,$room_id);
            if($checkAdmin['status'] === true){
                // remove admin from array
                // return success message
                array_splice($checkAdmin['admins'],$checkAdmin['location'], 1);
                RoomMember::where('room_id', $room_id)->update(['admins'=>$checkAdmin['admins']]);
                $message['auth'] = __('api.admin_removed');
                $target_user = $this->userObj($target_user_id);
                $userName = $target_user->name;
                $message['socket_status'] = "Remove admin";
                $message['socket_name'] =  $userName;
                return $this->successResponse([], $message);
            }
            else{
                //  already not an admin
                $message = __('api.not_admin');
                return $this->errorResponse($message, []);
            }
        }
        else{
            // not authorized message and return false
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }
    }

    public function make_room_member(Request $request){

        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $target_user_id = $request->input('user_id');
        // check room owner
        $checkObj = new RoomPrivileges();
        $checkOwner = $checkObj->check_room_owner($auth,$room_id);
        if($checkOwner){
            // check if already member
            $checkMember = $checkObj->check_room_member($target_user_id,$room_id);
            if($checkMember['status'] === true){
                $message = __('api.room_already_joined');
                return $this->successResponse([], $message);
            }
            else{
                // add user to join_user
                array_push($checkMember['members'], $target_user_id);
                RoomMember::where('room_id', $room_id)->update(['join_user'=>$checkMember['members']]);
                $message['auth'] = __('api.room_joined_success');
                $target_user = $this->userObj($target_user_id);
                $userName = $target_user->name;
                $message['socket_status'] = "Add member";
                $message['socket_name'] =  $userName;
                return $this->successResponse([], $message);
            }
        }else{
            // not authorized message and return false
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }

    }

    public function remove_room_member(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $target_user_id = $request->input('user_id');
        // check room owner
        $checkObj = new RoomPrivileges();
        $checkOwner = $checkObj->check_room_owner($auth,$room_id);
        if($checkOwner){
            // check if already member
            $checkMember = $checkObj->check_room_member($target_user_id,$room_id);
            if($checkMember['status'] === true){
                // remove user id from array and update record
                array_splice($checkMember['members'],$checkMember['location'], 1);
                RoomMember::where('room_id', $room_id)->update(['join_user'=>$checkMember['members']]);
                $message['auth'] = __('api.room_unjoined');
                $target_user = $this->userObj($target_user_id);
                $userName = $target_user->name;
                $message['socket_status'] = "Remove member";
                $message['socket_name'] =  $userName;
                return $this->successResponse([], $message);
            }
            else{
                $message = __('api.room_not_joined');
                return $this->successResponse([], $message);
            }
        }else{
            // not authorized message and return false
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }
    }

}
