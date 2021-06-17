<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Vip_tiers;
use Illuminate\Http\Request;
use Validator;
use DB;



class RoomController extends Controller
{


    public function create_room_password(Request $request){

        if ($this->user()->can('room_password', Room::class)) {
            return $this->successResponse(null, 'authorized');
        }
        else{
            return $this->errorResponse('un-authorized');
        }
    }
    /**
     * store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'privileges.*' => 'required',
            'renew_price' => 'required',
            'name' => 'required',
            'price' => 'required'
        ]);

        $tier = new Vip_tiers;
        $tier->privileges = $request->privileges;
        $tier->renew_price = $request->renew_price;
        $tier->name = $request->name;
        $tier->price = $request->price;
        $tier->save();
        dd($tier);
    }

    public function viewObject(){
        $query = Vip_tiers::where('id' , 2)->get();
        return $this->successResponse($query,'done');
    }

    public function getRooms(Request $request)
    {
        $rooms = new Room;
        
        if ($request->input('country_id')) {
            $rooms = $rooms->where('country_id',$request->input('country_id'));
        }
        
        if ($request->input('category_id')) {
            $rooms = $rooms->where('category_id',$request->input('category_id'));
        }

        $rooms = $rooms->with('category','country','user')->paginate(15);

        return $this->successResponse($rooms);
    }

    public function createRoom(Request $request)
    {
        $room = new Room;
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'country_id' => 'required|exists:contries,id',
            'join_fees' => 'required'
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
            $data['lang'] = ($request->input('lang')) ? $request->input('lang') : null;
            $data['broadcast_message'] = ($request->input('broadcast_message')) ? $request->input('broadcast_message') : null;
            $data['password'] = ($request->input('password')) ? $request->input('password') : null;
            $data['main_image'] = ($request->input('main_image')) ? $this->uploadBase64($request->input('main_image')) : 'defualtImage';
            $data['background'] = ($request->input('background')) ? $this->uploadBase64($request->input('background')) : 'defualtBackground';
            $data['join_fees'] = $request->input('join_fees');
            $data['category_id'] = $request->input('category_id');
            $data['country_id'] = $request->input('country_id');

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
}
