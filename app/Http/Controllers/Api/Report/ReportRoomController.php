<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\RoomReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = [
            'archive' => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            if (request('archive') == 0){
                $data['user'] = RoomReport::where('archive', 0)->select('id','reporter_id','reported_room')->get();
            }else{
                $data['user'] = RoomReport::where('archive', 1)->select('id','reporter_id','reported_room')->get();
            }
            $data['user']->map(function ($item)  {
                $item->reporter_name = $item->user->name;
                $item->room_name = $item->room->name;

                unset($item->room);
                unset($item->user);
                unset($item->reporter_id);
                unset($item->reported_room);

            });

            return $this->successResponse($data);
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $this->auth();

        $rules = [
            'reported_room' => 'required',
            'reason' => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        if($auth){
            $input = $request->all();
            $input['reporter_id'] = $auth ;
            $input['archive'] = 0 ;

            RoomReport::create($input);
            return $this->successResponse(null, __('api.Complaint'));
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $data['user'] = RoomReport::where('id',$id)->select('id','reporter_id','reported_room','reason')->first();
            $data['user']->reporter_name = $data['user']->user["name"];
            $data['user']->room_name = $data['user']->room["name"];

            unset($data['user']->user);
            unset($data['user']->room);
            unset($data['user']->reporter_id);
            unset($data['user']->reported_room);

            return $this->successResponse($data);
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
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
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
            $data = RoomReport::findOrFail($id);
            if ($data->archive == 0) {
                $data->where('id', $id)->update(['archive' => 1]);
                return $this->successResponse(null, __('api.Deleted'));
            }else{
                return $this->errorResponse(__('api.alreadyArchived'));
            }
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
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
