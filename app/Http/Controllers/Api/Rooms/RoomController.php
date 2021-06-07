<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    //

//    public function create_room_password(Request $request){
//        return $this->successResponse($request->user(), 'authorized');
//        if ($request->user()->cannot('room_password', Room::class)) {
//            abort(403);
//        }
//        else{
//            return $this->successResponse(null, 'authorized');
//        }
//    }
}
