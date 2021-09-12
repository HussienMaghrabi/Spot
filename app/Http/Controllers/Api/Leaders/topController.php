<?php

namespace App\Http\Controllers\Api\Leaders;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\ban;
use App\Models\Item;
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
use App\Models\RoomMember;
use App\Models\Sender_top_daily;
use App\Models\Sender_top_monthly;
use App\Models\Sender_top_weekly;
use App\Models\User;
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

    public function getTop(){
        $data['recharge']['daily'] = Recharge_top_daily::select('total','user_id')->get();
        $data['recharge']['daily']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['recharge']['weekly'] = Recharge_top_weekly::select('total','user_id')->get();
        $data['recharge']['weekly']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['recharge']['monthly'] = Recharge_top_monthly::select('total','user_id')->get();
        $data['recharge']['monthly']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['Sender']['daily'] = Sender_top_daily::select('total','user_id')->get();
        $data['Sender']['daily']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['Sender']['weekly'] = Sender_top_weekly::select('total','user_id')->get();
        $data['Sender']['weekly']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['Sender']['monthly'] = Sender_top_monthly::select('total','user_id')->get();
        $data['Sender']['monthly']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['Receiver']['daily'] = Receiver_top_daily::select('total','user_id')->get();
        $data['Receiver']['daily']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['Receiver']['weekly'] = Receiver_top_weekly::select('total','user_id')->get();
        $data['Receiver']['weekly']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['Receiver']['monthly'] = Receiver_top_monthly::select('total','user_id')->get();
        $data['Receiver']['monthly']->map(function ($item)
        {
            $item->name = $item->user->name;
            $item->image = $item->user->profile_pic;

            unset($item->user);
            unset($item->user_id);
        });

        $data['Room']['daily'] = Room_top_daily::select('total','room_id')->get();
        $data['Room']['daily']->map(function ($item)
        {
            $item->name = $item->room->name;
            $item->image = $item->room->main_image;

            unset($item->room);
            unset($item->room_id);
        });

        $data['Room']['weekly'] = Room_top_weekly::select('total','room_id')->get();
        $data['Room']['weekly']->map(function ($item)
        {
            $item->name = $item->room->name;
            $item->image = $item->room->main_image;

            unset($item->room);
            unset($item->room_id);
        });

        $data['Room']['monthly'] = Room_top_monthly::select('total','room_id')->get();
        $data['Room']['monthly']->map(function ($item)
        {
            $item->name = $item->room->name;
            $item->image = $item->room->main_image;

            unset($item->room);
            unset($item->room_id);
        });

        return $this->successResponse($data) ;



    }

    public function getTopInRoomD(Request $request){
        $room_id = $request->input('room_id');
        $now = Carbon::now()->subDay()->format('Y-m-d');
        $activeArray = User_gifts::where('room_id',$room_id)
            ->where('user_gifts.created_at', '>=', $now)
            ->groupByRaw('sender_id')
            ->select(DB::raw('sum(price_gift) as total'), 'sender_id')
            ->orderByDesc('total')
            ->get();
        if($activeArray == null){
            return $this->successResponse([]) ;
        }

        $totalCoins = 0;
        $it = 0;

        $ids = $activeArray->pluck('sender_id')->toArray();
        $Coins = $activeArray->pluck('total')->toArray();
        foreach ($Coins as $single){
            $totalCoins +=  (int)$single;
        }
        $room['top_senders'] = User::whereIn('id',$ids)->orderBy('vip_role', 'DESC')->select('id','name','profile_pic as image','user_level','karizma_level','vip_role')->get();
        foreach ($room['top_senders'] as $item){
            $item->total_coins = (int)$activeArray[$it]['total'];
            $it++;
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
            unset($item->badge);
            unset($item->charging_level);
            unset($item->active_badge_id);
            unset($item->vip_role);
            unset($item->vip);
        }
        $room['total_gifts_coins'] = $totalCoins;
        return $this->successResponse($room);
    }


    public function getTopInRoomW(Request $request){
        $room_id = $request->input('room_id');
        $now = Carbon::now()->subWeek()->format('Y-m-d');
        $activeArray = User_gifts::where('room_id',$room_id)
            ->where('user_gifts.created_at', '>=', $now)
            ->groupByRaw('sender_id')
            ->select(DB::raw('sum(price_gift) as total'), 'sender_id')
            ->orderByDesc('total')
            ->get();
        if($activeArray == null){
            return $this->successResponse([]) ;
        }

        $totalCoins = 0;
        $it = 0;

        $ids = $activeArray->pluck('sender_id')->toArray();
        $Coins = $activeArray->pluck('total')->toArray();
        foreach ($Coins as $single){
            $totalCoins +=  (int)$single;
        }
        $room['top_senders'] = User::whereIn('id',$ids)->orderBy('vip_role', 'DESC')->select('id','name','profile_pic as image','user_level','karizma_level','vip_role')->get();
        foreach ($room['top_senders'] as $item){
            $item->total_coins = (int)$activeArray[$it]['total'];
            $it++;
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
            unset($item->badge);
            unset($item->charging_level);
            unset($item->active_badge_id);
            unset($item->vip_role);
            unset($item->vip);
        }
        $room['total_gifts_coins'] = $totalCoins;
        return $this->successResponse($room);
    }



}
