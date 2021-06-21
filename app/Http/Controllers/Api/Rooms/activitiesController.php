<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\activitie;
use \App\Models\Room;
use \App\Models\User;
use Validator;
use DB;
use Carbon\Carbon;


class activitiesController extends Controller
{
    public function getActivities(Request $request)
    {
        $activitie = new activitie;
        $activitie = $activitie->with('room')->paginate(15);
        return $this->successResponse($activitie);
    }
    
    public function storeActivities(Request $request)
    {
        // store activitie
        $rules = [
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required',
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
        DB::beginTransaction();
        $data = array();
        $userId = $this->auth();
        try {
            if(!empty(Room::where('room_owner',$userId)->where('id',$request->input('room_id'))->first())) //check on user owned room
            {
                // if limits in one day
                $limit = activitie::where('room_id',$request->input('room_id'))->where('user_id',$userId)->where('date',Carbon::today())->get();
                // dd(Carbon::today());
                // dd($limit->count());
                if($limit->count() >= 3)
                {
                    return $this->successResponse($data,'limits for day is over');
                }
                if(user::where('id',$userId)->first()->coins < 250){
                    return $this->successResponse($data,'your coins not enogh to create an activitie');
                }
                // return $this->successResponse($data,'correct');
                $activitie = new activitie;
                $data['name'] = $request->input('name');
                $data['desc'] = $request->input('desc');
                $data['room_id'] = $request->input('room_id');
                $data['user_id'] = $userId;
                $data['coin_fees'] = 250;
                $data['date'] = Carbon::now();
                // $data['image'] = ()
                $activitie = $activitie::create($data);
                if($activitie)
                {
                    $user = user::where('id',$userId)->first();
                    $user->update(['coins'=> $user->coins - 250]);
                }
                DB::commit();
                return $this->successResponse($data);
            }else {
                return $this->errorResponse($data,'room or admin got error');
            }
        } catch (\Exption $e) {
            DB::rollback();
            return $this->formatErrors($e);
        }
    }
}
