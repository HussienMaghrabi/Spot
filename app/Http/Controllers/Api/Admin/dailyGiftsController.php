<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\login_check;
use Illuminate\Http\Request;
use App\Models\daily_gift;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class dailyGiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = $this->auth();
        $daily_gift = daily_gift::select('id','image_link as image','gift_id','item_id','coins','name')->get();
        $dailyCheck = login_check::where('user_id', $auth)->first();
        if($dailyCheck) {
            if($dailyCheck->last_login_day <= date('Y-m-d', strtotime("-1 day"))){
                $daily_gift['claimed'] = false;
            }else{
                $daily_gift1['claimed'] = true;
            }
            if ($dailyCheck->last_login_day <= date('Y-m-d', strtotime("-2 days"))) {
                $daily_gift1['last_daily_gift'] = 1;
            } else {
                if ($dailyCheck->last_daily_gift == 7) {
                    $daily_gift1['last_daily_gift'] = 7;
                } else if ($dailyCheck->last_daily_gift != 7 && $dailyCheck->last_login_day == date('Y-m-d')) {
                    $daily_gift1['last_daily_gift'] = $dailyCheck->last_daily_gift;
                } else {
                    $daily_gift1['last_daily_gift'] = $dailyCheck->last_daily_gift + 1;
                }
            }
        }else{
            $daily_gift1['claimed'] = false;
            $daily_gift1['last_daily_gift'] = 1;
        }
        $final = [];
        array_push($final,$daily_gift);
        array_push($final,$daily_gift1);
        $message = __('api.success');
        return $this->successResponse($final,$message);
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
        $rules =  [
            'name'    => 'required',
            ];
            $validator = Validator::make(request()->all(), $rules);
            if($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            // check on gift
            if($request->gift_id){
                $gifts = DB::table('gifts')->where('id',$request->gift_id)->first();
                if(empty($gifts)){
                    return $this->errorResponse('this gift Not Found');
                    // if(empty($gifts) && !empty(daily_gift::where('gift_id',$request->gift_id)->first()))
                    // {
                    //     return $this->errorResponse('this gift already taken');
                    // }
                }
            }
            // check on item
            if($request->item_id){
                $item = DB::table('items')->where('id',$request->item_id)->first();
                if(empty($item)){
                    return $this->errorResponse('this item Not Found');
                    // if(daily_gift::where('item_id',$request->item_id)->first())
                    // {
                    //     return $this->errorResponse('this item already taken');
                    // }
                }
            }

            // begin store
            if (daily_gift::get()->count() > 7) {
                return $this->errorResponse('cant add more then 7 gifts');
            }
            DB::beginTransaction();
            $data = [];
            try{
                $data['name'] = $request->name;
                if($request->image_link)
                {
                    $data['image_link'] = $this->uploadBase64($request->image_link);
                }
                if ($request->gift_id) {
                    $data['gift_id'] = $request->gift_id;
                }
                if ($request->item_id) {
                    $data['item_id'] = $request->item_id;
                }
                if ($request->coins) {
                    $data['coins'] = $request->coins;
                }
                $stored = DB::table('daily_gift')->insert($data);
                DB::commit();
                return $this->successResponse($data, 'success added');
                // data stored
            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatErrors($e,'fatel error');
                // something went wrong
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
        $dailyObj = daily_gift::where('id',$id)->first();
        if(!$dailyObj)
        {
            return $this->errorResponse('daily gift not found');
        }
            // check on gift
            if($request->gift_id){
                $gifts = DB::table('gifts')->where('id',$request->gift_id)->first();
                if(empty($gifts)){
                    return $this->errorResponse('this gift Not Found');
                    // if(empty($gifts) && !empty(daily_gift::where('gift_id',$request->gift_id)->first()))
                    // {
                    //     return $this->errorResponse('this gift already taken');
                    // }
                }
            }
            // check on item
            if($request->item_id){
                $item = DB::table('items')->where('id',$request->item_id)->first();
                if(empty($item)){
                    return $this->errorResponse('this item Not Found');
                    // if(daily_gift::where('item_id',$request->item_id)->first())
                    // {
                    //     return $this->errorResponse('this item already taken');
                    // }
                }
            }

            // begin store
            DB::beginTransaction();
            $data = [];
            try{
                if($request->name)
                {
                    $data['name'] = $request->name;
                }
                if($request->image_link)
                {
                    $data['image_link'] = $this->uploadBase64($request->image_link);
                }
                if ($request->gift_id) {
                    $data['gift_id'] = $request->gift_id;
                    $data['item_id'] = null;
                    $data['coins'] = null;
                }
                if ($request->item_id) {
                    $data['item_id'] = $request->item_id;
                    $data['gift_id'] = null;
                    $data['coins'] = null;
                }
                if ($request->coins) {
                    $data['coins'] = $request->coins;
                    $data['gift_id'] = null;
                    $data['item_id'] = null;
                }
                $stored = DB::table('daily_gift')->where('id',$id)->update($data);
                DB::commit();
                return $this->successResponse($data, 'success added');
                // data stored
            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatErrors($e,'fatel error');
                // something went wrong
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
        if(!daily_gift::where('id',$id)->first()){
            return $this->errorResponse("daily gift not found");
        }
        DB::beginTransaction();
        $data = [];
        try{
            daily_gift::where('id',$id)->delete();
            DB::commit();
            return $this->successResponse($data, 'success deleted');
            // data stored
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatErrors($e,'fatel error');
            // something went wrong
        }
    }
}
