<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\ActivityImage;
use App\Models\UserActivities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\activitie;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class activitiesController extends Controller
{
    public function getActivities(Request $request)
    {
        $data = activitie::with('room')->paginate(15);
        $data->map(function ($item){
            if($item->image == null){
                $item->image = ActivityImage::where('id', $item->image_id)->pluck('image as image')->first();

            }
        });
        return $this->successResponse($data);
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
                $today = Carbon::now()->format('Y-m-d');
                $limit = activitie::where('room_id',$request->input('room_id'))->where('user_id',$userId)->where('created_at', '>=' ,$today)->get();
                if($limit->count() >= 3)
                {
                    $message = __('api.activity_limit');
                    return $this->errorResponse($message,[]);
                }
                if(user::where('id',$userId)->first()->coins < 250){
                    $message = __('api.NoCoins');
                    return $this->errorResponse($message, []);
                }
                $data['name'] = $request->input('name');
                $data['desc'] = $request->input('desc');
                $data['room_id'] = $request->input('room_id');
                $data['user_id'] = $userId;
                $data['coin_fees'] = 250;
                $dueDateTime = Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->format('Y-m-d');
                $data['date'] = $dueDateTime;
                $startTime = Carbon::createFromTime($request->input('start_time'));
                $data['start'] = $startTime;
                $data['duration'] = $request->input('duration');
                if (request('image')) {
                    $data['image'] = $this->uploadFile(request('image'), 'activities');
                }elseif (request('image_id')) {
                    $data['image_id'] =  $request->input('image_id');
                }else{
                    return $this->errorResponse(__('api.imageRequired'),[]);
                }
                $activitie = activitie::create($data);
                if($activitie)
                {
                    $user = user::where('id',$userId)->first();
                    $user->update(['coins'=> $user->coins - 250]);
                }
                DB::commit();

                $item = activitie::where('id',$activitie->id)->select('name','desc','room_id','user_id','coin_fees','date','duration','start','image')->first();
                $message = __('api.success');
                return $this->successResponse($item,$message);
            }else {
                $message = __('api.no');
                return $this->errorResponse($message,[]);
            }
        } catch (\Exption $e) {
            DB::rollback();
            return $this->formatErrors($e);
        }
    }

    public function getImage()
    {
        $data = ActivityImage::get();
        return $this->successResponse($data);
    }

    public function joinActivity(Request $request){
        $rules = [
            'activity_id' => 'required',
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
        $auth =  $this->auth();
        $user = User::where('id', $auth)->first();
        if($user === null){
            $message = __('api.Authorization');
            return $this->errorResponse($message, []);
        }
        else{
            $activity_id = $request->input('activity_id');
            $activity = activitie::where('id', $activity_id)->first();
            if($activity === null){
                $message = __('api.activity_fail');
                return $this->errorResponse($message, []);
            }
            else{
                $data['user_id'] = $auth;
                $data['activity_id'] = $activity_id;
                UserActivities::create($data);
                $message = __('api.success');
                $data = $this->getUsers($activity_id);
                return $this->successResponse($data, $message);
            }
        }
    }

    public function leaveActivity(Request $request){
        $rules = [
            'activity_id' => 'required',
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
        $auth =  $this->auth();
        $user = User::where('id', $auth)->first();
        if($user === null){
            $message = __('api.Authorization');
            return $this->errorResponse($message, []);
        }
        else{
            $activity_id = $request->input('activity_id');
            $activity = activitie::where('id', $activity_id)->first();
            if($activity === null){
                $message = __('api.activity_fail');
                return $this->errorResponse($message, []);
            }
            else{
                UserActivities::where('activity_id', $activity_id)->where('user_id', $auth)->delete();
                $message = __('api.success');
                $data = $this->getUsers($activity_id);
                return $this->successResponse($data, $message);
            }
        }

    }

    public function getActivityMembers(Request $request){
        $rules = [
            'activity_id' => 'required',
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
        $activity_id = $request->input('activity_id');
        $activity = activitie::where('id', $activity_id)->first();
        if($activity === null){
            $message = __('api.activity_fail');
            return $this->errorResponse($message, []);
        }
        else{
            $message = __('api.success');
            $data = $this->getUsers($activity_id);
            return $this->successResponse($data, $message);
        }

    }

    public function getUsers($activityId){
        $data = UserActivities::where('activity_id', $activityId)->select('user_id', 'activity_id')->get();
        $data->map(function ($user){
            $user->id = $user->user->id;
            $user->name = $user->user->name;
            $user->image = $user->user->profile_pic;
            unset($user->user);
        });
        return $data;
    }

}
