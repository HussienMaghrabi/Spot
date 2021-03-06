<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Room;
use App\Models\RoomMember;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserRoom;
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
        $sql = RoomMember::where('room_id',$room_id)->first();
        if($sql === null){
            RoomMember::create(['room_id' => $room_id]);
        }
        $query = RoomMember::where('room_id',$room_id)->pluck('follow_user')->toArray();
        $this->follow_user_room($auth,$room_id);
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

    public function follow_user_room($user_id,$room_id)
    {
        $var = UserRoom::where('user_id',$user_id)->first();
        if($var === null){
            UserRoom::create(['user_id' => $user_id]);
        }
        $query = UserRoom::where('user_id',$user_id)->pluck('follow_room')->toArray();

        if($query[0] == null){
            $array[] = (string)$room_id;
            UserRoom::where('user_id', $user_id)->update(['follow_room' => $array ]);
            $message = __('api.room_followed_success');
            return $this->successResponse(null, $message);

        }
        $exist = in_array((string)$room_id, $query[0]);
        if($exist){
            $message = __('api.room_already_followed');
            return $this->errorResponse($message);
        }else{
            array_push($query[0], (string)$user_id);
            UserRoom::where('user_id', $user_id)->update(['follow_room' => $query[0] ]);

        }

    }

    public function unFollow_room(Request $request){
        if ($request->has('user_id')){
            $auth = $request->input('user_id');
        }else{
            $auth = $this->auth();
        }
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('follow_user')->toArray();
        $this->unFollow_user_room($auth,$room_id);
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

    public function unFollow_user_room($user_id,$room_id)
    {
        $var = UserRoom::where('user_id',$user_id)->first();
        if($var === null){
            UserRoom::create(['user_id' => $user_id]);
        }
        $query = UserRoom::where('user_id',$user_id)->pluck('follow_room')->toArray();

        if($query[0] == null){
            $message = __('api.room_not_followed');
            return $this->successResponse(null, $message);
        }
        $index = array_search((string)$room_id, $query[0]);
        if ($index === false){
            $message = __('api.room_not_followed');
            return $this->errorResponse($message);
        }else{
            $result = array_splice($query[0], $index, 1);
            UserRoom::where('user_id', $user_id)->update(['follow_room' => $query[0] ]);

        }
    }

    public function room_joiners(Request $request){
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('join_user')->toArray();
        if($query[0] == null){
            $message = __('api.room_no_active');
            return $this->errorResponse($message);
        }
        $checkObj = new RoomPrivileges();

        $result = User::whereIn('id', $query[0])->select('id','name','profile_pic as image')->paginate(15);
        $result->map(function ($item) use ($checkObj, $room_id){
            $callFunction = $checkObj->check_room_admin($item->id, $room_id);
            $item->is_admin = $callFunction['status'];

            unset($item->member);
        });
        return $this->successResponse($result);
    }

    public function join_room(Request $request){
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $var = RoomMember::where('room_id',$room_id)->first();
        if($var === null){
            RoomMember::create(['room_id' => $room_id]);
        }
        $user_coins = User::where('id',$auth)->pluck('coins')->first();
        $join_fees = Room::where('id',$room_id)->pluck('join_fees')->first();
        $user_final_coins = $user_coins - $join_fees ;
        if($user_coins >= $join_fees){
            $query = RoomMember::where('room_id',$room_id)->pluck('join_user')->toArray();
            $this->join_user_room($auth,$room_id);
            if($query[0] == null){
                $array[] = (string)$auth;
                RoomMember::where('room_id', $room_id)->update(['join_user' => $array ]);
                User::where('id',$auth)->update(['coins' => $user_final_coins ]);
                $message = __('api.room_joined_success');
                $this->BadgeRoomJoin($room_id);
                return $this->successResponse($user_final_coins, $message);
            }
            $exist = in_array((string)$auth, $query[0]);
            if($exist){
                $message = __('api.room_already_joined');
                return $this->errorResponse($message,[]);
            }else{
                array_push($query[0], (string)$auth);
                RoomMember::where('room_id', $room_id)->update(['join_user' => $query[0] ]);
                User::where('id',$auth)->update(['coins' => $user_final_coins ]);
                $message = __('api.room_joined_success');
                $this->BadgeRoomJoin($room_id);
                return $this->successResponse($user_final_coins, $message);
            }
        }else{
            $message = __('api.NoCoins');
            return $this->errorResponse($message,[]);
        }
    }

    // handle notification system to the room owner
    public function BadgeRoomJoin($room_id){
        $room = Room::where('id', $room_id)->first();
        $roomOwner = $room->room_owner;
        $roomJoiners = RoomMember::where('room_id', $room_id)->pluck('join_user')->toArray();
        $joinCount = count($roomJoiners[0]);
        $data = Badge::where('category_id',2)->get();
        $badge_id = -1 ;
        foreach ($data as $item){
            if($joinCount >= $item->amount){
                $badge_id =$item->id;
            }else{
                break;
            }
        }
        if ($badge_id != -1){
            $var = UserBadge::where('user_id',$roomOwner)->where('badge_id', $badge_id)->first();
            if (!$var){
                $input['user_id'] = $roomOwner;
                $input['badge_id'] = $badge_id ;
                UserBadge::create($input);
            }
        }
    }

    public function join_user_room($user_id,$room_id)
    {
        $var = UserRoom::where('user_id',$user_id)->first();
        if($var === null){
            UserRoom::create(['user_id' => $user_id]);
        }
        $query = UserRoom::where('user_id',$user_id)->pluck('room_join')->toArray();
        if($query[0] == null){
            $array[] = (string)$room_id;
            UserRoom::where('user_id', $user_id)->update(['room_join' => $array ]);
            return $this->successResponse([]);


        }
        $exist = in_array((string)$room_id, $query[0]);
        if($exist){
            $message = __('api.room_already_followed');
            return $this->errorResponse($message,[]);
        }else{
            array_push($query[0], (string)$room_id);
            UserRoom::where('user_id', $user_id)->update(['room_join' => $query[0] ]);

        }

    }

    public function leave_room(Request $request){
        if ($request->has('user_id')){
            $auth = $request->input('user_id');
        }else{
            $auth = $this->auth();
        }
        $room_id = $request->input('room_id');
        $query = RoomMember::where('room_id' , $room_id)->pluck('join_user')->toArray();
        $this->unjoin_user_room($auth,$room_id);
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

    public function unjoin_user_room($user_id,$room_id)
    {
        $var = UserRoom::where('user_id',$user_id)->first();
        if($var === null){
            UserRoom::create(['user_id' => $user_id]);
        }
        $query = UserRoom::where('user_id',$user_id)->pluck('room_join')->toArray();

        if($query[0] == null){
            $message = __('api.room_not_followed');
            return $this->successResponse(null, $message);
        }
        $index = array_search((string)$room_id, $query[0]);
        if ($index === false){
            $message = __('api.room_not_followed');
            return $this->errorResponse($message);
        }else{
            $result = array_splice($query[0], $index, 1);
            UserRoom::where('user_id', $user_id)->update(['room_join' => $query[0] ]);

        }
    }

    public function user_rooms_join(){
        $auth =$this->auth();
        $query = UserRoom::where('user_id' , $auth)->pluck('room_join')->toArray();
        if($query == null){
            $message = __('api.room_no_active');
            return $this->errorResponse($message);
        }
        $result = Room::whereIn('id', $query[0])->select('id','name','main_image as image' , 'agora_id',)->paginate(15);
        $result->map(function ($item){
            $item->active_count = $item->member->active_count;

            unset($item->member);
        });
        return $this->successResponse($result);
    }

    public function user_rooms_follow(){
        $auth =$this->auth();
        $query = UserRoom::where('user_id' , $auth)->pluck('follow_room')->toArray();
        if($query == null){
            $message = __('api.room_no_active');
            return $this->errorResponse($message);
        }
        $result = Room::whereIn('id', $query[0])->select('id','name','main_image as image' , 'agora_id',)->paginate(15);
        $result->map(function ($item){
            $item->active_count = $item->member->active_count;

            unset($item->member);
        });
        return $this->successResponse($result);
    }

    public function room_ban_enter_users(Request $request){
        $roomPrivilege = new RoomPrivileges();
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $owner = false;
        $admin = false;
        $owner = $roomPrivilege->check_room_owner($auth,$room_id);
        $checkAdmin = $roomPrivilege->check_room_admin($auth,$room_id);
        $admin = $checkAdmin['status'];
        if($owner || $admin){
            $query = RoomMember::where('room_id' , $room_id)->pluck('ban_enter')->toArray();
            if($query[0] == null){
                $message = __('api.no_bans');
                return $this->errorResponse($message,[]);
            }
            $result = User::whereIn('id', $query[0])->select('id','name','profile_pic as image')->paginate(15);
            return $this->successResponse($result);
        }else{
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }

    }



}
