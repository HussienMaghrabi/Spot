<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Models\RecentRoom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecentRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('recent_rooms')
            ->leftJoin('rooms', 'recent_rooms.rooms_id','=','rooms.id')
            ->groupBy('rooms_id')
            ->select('recent_rooms.id','rooms_id', 'rooms.name' , 'rooms.id')
            ->get();

        return $this->successResponse($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rooms_id.*' => 'required',
            'user_id' => 'required'
        ]);

        $tier = new RecentRoom;
        $tier->rooms_id = $request->rooms_id;
        $tier->user_id = $request->user_id;
        $tier->save();
        dd($tier);




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
