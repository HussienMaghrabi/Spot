<?php

namespace App\Http\Controllers\Api\Leaders;

use App\Http\Controllers\Controller;
use App\Models\ban;
use App\Models\Receiver_top_daily;
use App\Models\Receiver_top_monthly;
use App\Models\Receiver_top_weekly;
use App\Models\Recharge_top_daily;
use App\Models\Recharge_top_monthly;
use App\Models\Recharge_top_weekly;
use App\Models\Recharge_transaction;
use App\Models\Room_top_daily;
use App\Models\Room_top_monthly;
use App\Models\Room_top_weekly;
use App\Models\Sender_top_daily;
use App\Models\Sender_top_monthly;
use App\Models\Sender_top_weekly;
use App\Models\User_gifts;
use App\Models\User_Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class topController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function topRechargeD(){
        $items = Recharge_top_daily::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        return $this->successResponse($items, "done");
    }

    public function test(){
        $now = Carbon::now()->subMonth()->format('Y-m-d');
        $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->where('room_id', '!=', null)->groupByRaw('room_id')->select( DB::raw('sum(price_gift) as total'), 'room_id')->orderByDesc('total')->get();
        DB::table('room_top_monthlies')->truncate();
        foreach ($data['user'] as $user){
            $input['total'] =$user->total;
            $input['room_id'] = $user->room_id;
            $query = Room_top_monthly::create($input);
        }
    }

    public function topRechargeW(){
        $items = Recharge_top_weekly::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        return $this->successResponse($items, "done");
    }

    public function topRechargeM(){
        $items = Recharge_top_monthly::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        return $this->successResponse($items, "done");
    }

    public function topSenderD(){
        $items = Sender_top_daily::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });
        return $this->successResponse($items, "done");
    }

    public function topSenderW(){
        $items = Sender_top_weekly::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });
        return $this->successResponse($items, "done");
    }

    public function topSenderM(){
        $items = Sender_top_monthly::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });
        return $this->successResponse($items, "done");
    }

    public function topReceiverD(){

        $items = Receiver_top_daily::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });
        return $this->successResponse($items, "done");
    }

    public function topReceiverW(){

        $items = Receiver_top_weekly::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });
        return $this->successResponse($items, "done");
    }

    public function topReceiverM(){

        $items = Receiver_top_monthly::select('total','user_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });
        return $this->successResponse($items, "done");
    }

    public function topRoomD(){
        $items = Room_top_daily::select('total','room_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->room->name;
            $item->image = $item->room->main_image;

            unset($item->room);
            unset($item->room_id);
        });
        return $this->successResponse($items, "done");
    }

    public function topRoomW(){
        $items = Room_top_weekly::select('total','room_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->room->name;
            $item->image = $item->room->main_image;

            unset($item->room);
            unset($item->room_id);
        });
        return $this->successResponse($items, "done");
    }

    public function topRoomM(){
        $items = Room_top_monthly::select('total','room_id')->get();
        $items->map(function ($item)
        {
            $item->name = $item->room->name;
            $item->image = $item->room->main_image;

            unset($item->room);
            unset($item->room_id);
        });
        return $this->successResponse($items, "done");
    }


}
