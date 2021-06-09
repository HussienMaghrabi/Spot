<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Vip_tiers;
use Illuminate\Http\Request;


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
}
