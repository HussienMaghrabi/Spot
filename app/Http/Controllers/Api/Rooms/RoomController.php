<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomController extends Controller
{


    public function create_room_password(Request $request){

        if ($this->user()->can('room_password', Room::class)) {
            Room::where('id',$request->room_id)->update(['password'=>$request->password]);
            return $this->successResponse(null,__('api.success'));
        }
        else{
            return $this->errorResponse(__('api.Unauthorized'));
        }
    }

    public function update_room_password(Request $request){

        if ($this->user()->can('room_password', Room::class)) {
            Room::where('id',$request->room_id)->update(['password'=>$request->password]);
            return $this->successResponse(null,__('api.success'));
        }
        else{
            return $this->errorResponse(__('api.Unauthorized'));
        }
    }

    public function user_room()
    {
        $auth = $this->auth();
        if ($auth){
            $data = Room::where('room_owner',$auth)->select('id', 'name', 'desc', 'agora_id', 'main_image as image', 'category_id', 'country_id', 'room_owner')->first();
            if ($data){
                return $this->successResponse($data);
            }else{
                $message = __('api.noRoom');
                return $this->errorResponse($message,[]);
            }
        }else{
            return $this->errorResponse(__('api.Unauthorized'),[]);
        }

    }


    /**
     * store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRooms(Request $request)
    {
        $rooms = new Room;

        if ($request->input('country_id')) {
            $rooms = $rooms->where('country_id',$request->input('country_id'));
        }

        if ($request->input('category_id')) {
            $rooms = $rooms->where('category_id',$request->input('category_id'));
        }

        // $rooms = $rooms->user_ac

        $rooms = $rooms->select('id', 'name', 'desc', 'agora_id', 'main_image as image', 'category_id', 'country_id', 'room_owner')->with('category','country')->paginate(15);
        $rooms->map(function ($room){
            $room->active_count = $room->member->active_count;
            unset($room->member);
        });
        return $this->successResponse($rooms);
    }
    // list all pinned rooms
    public function pinnedRooms(){
        $query = Room::where('pinned', true)->paginate(15);
        return $this->successResponse($query, __('api.Updated'));

    }
    public function createRoom(Request $request)
    {
        $room = new Room;
        $rules = [
            'category_id' => 'required|exists:categories,id',
        ];

        $validator = Validator::make($request->all(), $rules );

        if($validator->fails())
        {
            $arrV = [];
            if($validator->fails()) {
                $arrV = [];
                foreach($validator->errors()->messages() as $k => $v){
                    foreach($v as $one){$arrV[$k] = $one;}}
                    return $this->errorResponse((object)$arrV);
                }
        }
        $auth = $this->auth();
        $room_owner =Room::where('room_owner',$auth)->first();
        if($room_owner){
            $message = __('api.already_have_room');
            return $this->errorResponse($message,[]);
        }else{
            $data = array();
            DB::beginTransaction();
            try {
                $data['room_owner'] = $auth;
                $data['name'] = $request->input('name');
                $data['desc'] = $request->input('desc');
                $data['category_id'] = $request->input('category_id');
                $data['agora_id'] = $data['room_owner'].$data['name'];

                if (request('main_image'))
                {
                    $data['main_image'] = $this->uploadFile(request('main_image'), 'rooms'.$auth);
                }

                $room = room::create($data);
                RoomMember::create([
                    'room_id'=>$room->id,
                    'follow_user'=>[],
                    'join_user'=>["$room->room_owner"],
                    'active_user'=>[],
                    'ban_enter'=>[],
                    'ban_chat'=>[],
                    'on_mic'=>[],
                    'admins'=>[],
                    'active_count'=>0
                ]);
                DB::commit();
                return $this->successResponse($room,'room stored successfully');
            } catch (\Exption $e) {
                DB::rollback();
                return $this->formatErrors($e);
            }
        }

    }
    public function updateRoom(Request $request)
    {

        $auth = $this->auth();
        $room = Room::where('room_owner',$auth);
        $data = array();
        DB::beginTransaction();
        try {
            $data = $request->except('main_image');
            if($request->name){
                $data['agora_id'] = $auth.$data['name'];
            }

            if (request('main_image'))
            {

                if (strpos($room->main_image, '/uploads/') !== false) {
                    $image = str_replace( asset('').'storage/', '', $room->main_image);
                    Storage::disk('public')->delete($image);
                }
                $input['main_image'] = $this->uploadFile(request('main_image'), 'rooms'.$auth);
            }

             $room->update($data);
            DB::commit();
            $room = Room::where('room_owner',$auth)->select(
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
            return $this->successResponse($room,'room updated successfully');
        } catch (\Exption $e) {
            DB::rollback();
            return $this->formatErrors($e);
        }
    }
    public function deleteRoom(Request $request)
    {
        $rules = [
            'room_id' => 'required|exists:rooms,id',
        ];

        $validator = Validator::make($request->all(), $rules );

        if($validator->fails())
        {
            $arrV = [];
            if($validator->fails()) {
                $arrV = [];
                foreach($validator->errors()->messages() as $k => $v){
                    foreach($v as $one){$arrV[$k] = $one;}}
                    return $this->errorResponse((object)$arrV);
                }
        }
        $room = Room::where('id',$request->input('room_id'));
        DB::beginTransaction();
        try {
            $room->delete();
            DB::commit();
            return $this->successResponse([],'room deleted successfully');
        } catch (\Exption $e) {
            DB::rollback();
            return $this->formatErrors($e);
        }
    }
    public function newRooms(){
        $now = Carbon::now()->subDay()->format('Y-m-d');
        $query = Room::where('created_at', $now)->select('id', 'name', 'desc', 'agora_id', 'room_owner', 'lang', 'broadcast_message', 'main_image as image', 'pinned', 'category_id', 'country_id')->paginate(15);
        $query->map(function ($room){
            $room->active_count = $room->member->active_count;

            unset($room->member);
        });
        return$this->successResponse($query);
    }
    public function checkRoom(){
        $auth = $this->auth();
        $query = Room::where('room_owner', $auth)->pluck('id')->first();
        if($query === null){
            return $this->successResponse(null);
        }else{
            return $this->errorResponse(null);
        }
    }

    public function updateRoomCategory(Request $request)
    {
        $roomPrivilege = new RoomPrivileges();
        $auth = $this->auth();
        $room_id = $request->input('room_id');
        $category_id = $request->input('category_id');
        $owner = false;
        $owner = $roomPrivilege->check_room_owner($auth,$room_id);
        if($owner){
            Room::where('id',$room_id)->update(['category_id'=>$category_id]);
            $result = Room::where('id',$room_id)->select('category_id')->get();
            $result->map(function ($item){
                $item->category_name = $item->category->name;

                unset($item->category);
            });
            $message = __('api.success');
            return $this->successResponse($result,$message);
        }else{
            $message = __('api.Unauthorized');
            return $this->errorResponse($message, []);
        }
    }
}
