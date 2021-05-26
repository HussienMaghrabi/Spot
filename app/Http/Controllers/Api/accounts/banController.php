<?php

namespace App\Http\Controllers\Api\accounts;

use App\Http\Controllers\Controller;
use App\Models\ban;
use App\Models\User;
use Illuminate\Http\Request;

class banController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // show list of banned users
    public function index()
    {
        $admin_id = $this->auth();
        $admin = Admin::where('id' , $admin_id)->get();
        $count = count($admin);
        if($count > 0){
            $data = ban::where('status' , 'banned')->select('id' , 'name' ,' profile_pic')->get();
        }
        return $this->successResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // ban user by id
    public function create(Request $request)
    {
        if(!$request->has('user_id')){
            $massage = __('api.missing_user');
            return $this->successResponse(null,$massage);
        }
        $admin_id = $this->auth();
        $admin = Admin::where('id' , $admin_id)->get();
        $count = count($admin);
        if($count > 0){
            $target_id = $request->input('user_id');
            $user = User::where('id' , $target_id)->select('name', 'profile_pic')->get();
            $input['user_id'] = $target_id;
            $input['admin_id'] = $admin_id;
            $input['name'] = $user[0]->name;
            $input['profile_pic'] = $user[0]->profile_pic;
            $data['banned-user'] = ban::create($input);

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
