<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\RecentRoom;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class RecentRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = $this->auth();
        $query = RecentRoom::where('user_id' , $auth)->pluck('rooms_id');
        $result = Room::whereIn('id', $query[0])->select('id','name')->get();
        return $this->successResponse($result, "test");
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

    public function viewObject(){
        $query = RecentRoom::where('id' , 2)->get();
        //$data = $query->privileges->json_decode();

        return $this->successResponse($query,'done');
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
    public function update(Request $request)
    {
        $auth = $this->auth();
        if($auth){
            $request->validate([
                'rooms_id' => 'required',
            ]);

            $items = RecentRoom::where('user_id',$auth)->pluck('rooms_id')->first();

            $key =  array_search($request->rooms_id,$items);
            $count_item = count($items);
            if($count_item == 9){

                if ($key){
                    $output = array_slice($items,$key);
                    return $this->successResponse($items);

                }

////                return $this->successResponse($items);
            }
////
//            $tier = new RecentRoom;
//            $tier->rooms_id = $request->rooms_id;
//            $tier->user_id = $auth;
//            $tier->save();
//            dd($tier);

        }else{
            return $this->errorResponse(__('api.Unauthorized'));
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
