<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\RecentRoom;
use App\Models\Room;

class RecentRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = $this->auth();
        $query = RecentRoom::where('user_id' , $auth)->pluck('rooms_id')->toArray();
        if($query == null){
            RecentRoom::create(['user_id' => $auth ]);
            return $this->errorResponse(__('api.noRecentRoom'));
        }

        $result = Room::whereIn('id', $query[0])->select('id','name','main_image as image' , 'agora_id')->get();
        $result->map(function ($item){
            $item->active_count = $item->member->active_count;

            unset($item->member);
        });
        return $this->successResponse($result);
    }


    public function last_room($id){
        $auth = $this->auth();
        $room_id = $id;
        $var = RecentRoom::where('user_id',$auth)->first();
        if($var === null){
            RecentRoom::create(['user_id' => $auth ]);
        }
        $query = RecentRoom::where('user_id',$auth)->pluck('rooms_id')->toArray();
        if($query[0] == null){
            $array[] = (string)$room_id;
            RecentRoom::where('user_id', $auth)->update(['rooms_id' => $array ]);
            $message = __('api.room_joined_success');
            return $this->successResponse(null, $message);
        }
        $exist = array_search((string)$room_id, $query[0]);
        if($exist === false){
            if(count($query[0]) == 10){
                array_splice($query[0],0,1);
                array_push($query[0], (string)$room_id);
                RecentRoom::where('user_id',$auth)->update(['rooms_id' => $query[0] ]);
                $message = __('api.room_joined_success');
                return $this->successResponse(null, $message);
            }
            array_push($query[0], (string)$room_id);
            RecentRoom::where('user_id', $auth)->update(['rooms_id' => $query[0] ]);
            $message = __('api.room_joined_success');
            return $this->successResponse(null, $message);
        }else{
            if($exist != count($query[0])){
                array_splice($query[0],$exist,1);
                array_push($query[0], (string)$room_id);
                RecentRoom::where('user_id',$auth)->update(['rooms_id' => $query[0] ]);
                $message = __('api.room_joined_success');
                return $this->successResponse(null, $message);
            }
        }
    }
}
