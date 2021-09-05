<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Item;
use App\Models\Room;
use App\Models\RoomMember;
use App\Models\User;
use App\Models\User_Item;
use App\Models\UserRoom;
use Illuminate\Http\Request;

class ActiveRoomController extends Controller
{
    public function enterRoom(Request $request)
    {
        $auth = $this->auth();

        $khra = new HandleRoomController();
//        $khra->checkBanEnter($request);
        if (($khra->checkBanEnter($request)) === true){
            $message = __('api.you_baned');
            return $this->errorResponse($message);
        }else{

            $room_id = $request->input('room_id');
            $room = Room::where('id',$room_id)->select(
                'id',
                'name',
                'desc',
                'agora_id',
                'room_owner',
                'lang',
                'broadcast_message',
                "main_image as image",
                'background',
                'join_fees',
                'category_id',
                'country_id')->first();
            $followArray = RoomMember::where('room_id',$room_id)->pluck('follow_user')->toArray();
            $joinArray = RoomMember::where('room_id',$room_id)->pluck('join_user')->toArray();
            $ban_chatArray = RoomMember::where('room_id',$room_id)->pluck('ban_chat')->toArray();

            foreach ($followArray[0] as $value){
                if($value == $auth){
                    $room['is_follow'] = 1;
                    break;
                }else{
                    $room['is_follow'] = 0;
                }
            }
            foreach ($joinArray[0] as $value){
                if($value == $auth){
                    $room['is_join'] = 1;
                    break;
                }else{
                    $room['is_join'] = 0;
                }
            }
            if($ban_chatArray[0] != null){
                foreach ($ban_chatArray[0] as $value){
                    if($value == $auth){
                        $room['is_ban_chat'] = 1;
                        break;
                    }else{
                        $room['is_ban_chat'] = 0;
                    }
                }
            }else{
                $room['is_ban_chat'] = 0;
            }

            $owner = User::where('id',$room->room_owner)->select('name', 'profile_pic as image')->get();
            $room['owner'] = $owner;

            $active_items = User_Item::where('user_id', $auth)->where('is_activated', 1)->pluck('item_id')->toArray();
            $item_details = Item::whereIn('id',$active_items)->select('name', 'img_link as image', 'file','cat_id')->get();

            $tmpItem = new Item();
            $tmpItem->name = "";
            $tmpItem->file = " ";
            $tmpItem->image = " ";
            $tmpItem->cat_id = 0;
            $room['active_mic_border'] = $tmpItem;
            $room['active_vehicle'] = $tmpItem;
            foreach ($item_details as $item){
                if($item->cat_id == 2){
                    $room['active_mic_border'] = $item;
                }elseif ($item->cat_id == 3){
                    $room['active_vehicle'] = $item;
                }
            }


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
                    return $this->successResponse($room, $message);
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
                    return $this->successResponse($room, $message);
                }
            }else{
                return $this->errorResponse(__('api.PasswordInvalid'));
            }
        }
    }

    public function room_active_user(Request $request){
        $auth = $this->auth();
        if($auth){
            $room_id = $request->input('room_id');
            $activeArray = RoomMember::where('room_id',$room_id)->pluck('active_user')->toArray();
            if($activeArray[0] == null){
             return $this->successResponse([]) ;
            }

            $room['active_user'] = User::whereIn('id',$activeArray[0])->orderBy('vip_role', 'DESC')->select('id','name','profile_pic as image','user_level','karizma_level','vip_role')->get();
            $room['active_user']->map(function ($item) use($room_id){
                $item->active_badge_id = $item->badge->where('active',1)->pluck('badge_id')->toArray();
                if(count($item->charging_level) == 0){
                    $item->chargingLevel = 1;
                }else{
                    $item->chargingLevel = $item->charging_level[0]->user_level;
                }
                if($item->vip_role != null){
                    $item->vip_image = $item->vip->image;
                }else{
                    $item->vip_image = " ";
                }
                $item->active_badge = Badge::whereIn('id', $item->active_badge_id)->select('id','name','img_link as image')->get();

                $ban_enterArray = RoomMember::where('room_id',$room_id)->pluck('ban_enter')->toArray();
                $ban_chatArray = RoomMember::where('room_id',$room_id)->pluck('ban_chat')->toArray();
                if($ban_enterArray[0]!= null) {
                    foreach ($ban_enterArray[0] as $value) {
                        if ($value == $item->id) {
                            $item->ban_enter = 1;
                            break;
                        } else {
                            $item->ban_enter = 0;
                        }
                    }
                }else{
                    $item->ban_enter =0;
                }
                if($ban_chatArray[0]!= null){
                    foreach ($ban_chatArray[0] as $value){
                        if($value == $item->id){
                            $item->ban_chat = 1;
                            break;
                        }else{
                            $item->ban_chat = 0;
                        }
                    }
                }else{
                    $item->ban_chat =0;
                }


                $active_items = User_Item::where('user_id', $item->id)->where('is_activated', 1)->pluck('item_id')->toArray();
                $item_details = Item::whereIn('id',$active_items)->select('name', 'img_link as image', 'file','cat_id')->get();

                $shit['active_mic_border'] = "";
                $shit['active_vehicle'] = "";
                foreach ($item_details as $detail){
                    if($detail->cat_id == 2){
                        $shit['active_mic_border'] = $detail;
                    }elseif ($detail->cat_id == 3){
                        $shit['active_vehicle'] = $detail;
                    }
                }
                $item->active_items = $shit;


                unset($item->badge);
                unset($item->charging_level);
                unset($item->active_badge_id);
                unset($item->vip_role);
                unset($item->vip);
            });
            $active_items = User_Item::where('user_id', $auth)->where('is_activated', 1)->pluck('item_id')->toArray();
            $item_details = Item::whereIn('id',$active_items)->select('name', 'img_link as image', 'file','cat_id')->get();

//            $room['active_mic_border'] = [];
//            $room['active_vehicle'] = [];
//            foreach ($item_details as $item){
//                if($item->cat_id == 2){
//                    $room['active_mic_border'] = $item;
//                }elseif ($item->cat_id == 3){
//                    $room['active_vehicle'] = $item;
//                }
//            }


            return $this->successResponse($room);
        }else{
            return $this->errorResponse(__('api.Authorization'),[]);
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
        $query = RoomMember::orderBy('active_count', 'DESC')->where('trend',0)->select('room_id','active_count','official')->paginate(15);
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
