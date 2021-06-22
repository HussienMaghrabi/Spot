<?php

namespace App\Http\Controllers\Api\Leaders;

use App\Http\Controllers\Controller;
use App\Models\ban;
use App\Models\Recharge_top_daily;
use App\Models\Recharge_top_monthly;
use App\Models\Recharge_top_weekly;
use App\Models\Recharge_transaction;
use App\Models\Sender_top_daily;
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
        $data = DB::table('recharge_top_dailies')
            ->leftJoin('users' , 'recharge_top_dailies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }

    public function test(){
        $now = Carbon::now()->subDay()->format('Y-m-d');
        $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->groupByRaw('sender_id')->select( DB::raw('sum(price_gift) as total'), 'sender_id')->orderByDesc('total')->get();
        DB::table('sender_top_dailies')->truncate();
        foreach ($data['user'] as $user){
            $input['total'] =$user->total;
            $input['user_id'] = $user->sender_id;
            $query = Sender_top_daily::create($input);
        }
    }

    public function topRechargeW(){
        $data = DB::table('recharge_top_weeklies')
            ->leftJoin('users' , 'recharge_top_weeklies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topRechargeM(){
        $data = DB::table('recharge_top_monthlies')
            ->leftJoin('users' , 'recharge_top_monthlies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topSenderD(){
        $data = DB::table('sender_top_dailies')
            ->leftJoin('users' , 'sender_top_dailies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topSenderW(){
        $data = DB::table('sender_top_weeklies')
            ->leftJoin('users' , 'sender_top_weeklies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topSenderM(){
        $data = DB::table('sender_top_monthlies')
            ->leftJoin('users' , 'sender_top_monthlies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }

    public function topReceiverD(){
        $data = DB::table('receiver_top_dailies')
            ->leftJoin('users' , 'receiver_top_dailies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topReceiverW(){
        $data = DB::table('receiver_top_weeklies')
            ->leftJoin('users' , 'receiver_top_weeklies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topReceiverM(){
        $data = DB::table('receiver_top_monthlies')
            ->leftJoin('users' , 'receiver_top_monthlies.user_id' , '=' , 'users.id')
            ->select( 'total', 'users.name', 'users.profile_pic as image' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topRoomD(){
        $data = DB::table('room_top_dailies')
            ->leftJoin('rooms' , 'room_top_dailies.room_id' , '=' , 'rooms.id')
            ->select( 'total', 'rooms.name' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topRoomW(){
        $data = DB::table('room_top_weeklies')
            ->leftJoin('rooms' , 'room_top_weeklies.room_id' , '=' , 'rooms.id')
            ->select( 'total', 'rooms.name' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }
    public function topRoomM(){
        $data = DB::table('room_top_monthlies')
            ->leftJoin('rooms' , 'room_top_monthlies.room_id' , '=' , 'rooms.id')
            ->select( 'total', 'rooms.name' )
            ->orderByDesc('total')
            ->get();
        return $this->successResponse($data, "done");
    }





    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
