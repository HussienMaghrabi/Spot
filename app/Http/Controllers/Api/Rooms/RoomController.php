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

//    public function store(Request $request)
//    {
//        dd(request('name'));
//        $request->validate([
//            'privileges.*' => 'required',
//            'renew_price' => 'required',
//            'name' => 'required',
//            'price' => 'required'
//        ]);
//
//        $tier = new Vip_tiers;
//        $tier->privileges = json_encode($request->privileges);
//        $tier->renew_price = $request->renew_price;
//        $tier->name = $request->name;
//        $tier->price = $request->price;
//        $tier->save();
//        dd($tier);
//
//    }
}
