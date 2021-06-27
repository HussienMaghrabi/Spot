<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Vip_tiers;
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

        $rooms = $rooms->select('id', 'name', 'desc', 'agora_id', 'main_image as image', 'category_id', 'country_id', 'room_owner')->with('category','country')->paginate(15);

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
            DB::commit();
            return $this->successResponse($room,'room stored successfully');
        } catch (\Exption $e) {
            DB::rollback();
            return $this->formatErrors($e);
        }
    }
    public function updateRoom(Request $request)
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
        $auth = $this->auth();
        $data = array();
        // $data['id'] = $request->input('room_id');
        DB::beginTransaction();
        try {
            $data['room_owner'] = $auth;
            $data['name'] = $request->input('name');
            $data['lang'] = ($request->input('lang')) ? $request->input('lang') : null;
            $data['broadcast_message'] = ($request->input('broadcast_message')) ? $request->input('broadcast_message') : null;
            $data['password'] = ($request->input('password')) ? $request->input('password') : null;
            $data['join_fees'] = $request->input('join_fees');
            $data['agora_id'] = $data['room_owner'].$data['name'];

            $room = $room->update($data);
            DB::commit();
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
        $query = Room::where('created_at', $now)->paginate(15);
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
}
