<?php

namespace App\Http\Controllers\Api\accounts;

use App\Http\Controllers\Controller;
use App\Models\ban;
use App\Models\User;
use App\Models\Admin;
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
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $data = ban::where('status' , 'banned')->select('id' , 'name' ,'profile_pic as image')->paginate(15);
            return $this->successResponse($data);
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
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
            return $this->errorResponse($massage);
        }
        $check = ban::where('user_id' , $request->input('user_id'))->where('status', "banned")->first();
        if($check){
            $massage = __('api.already_banned_user');
            return $this->errorResponse($massage);
        }

        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $target_id = $request->input('user_id');
            $user = User::where('id' , $target_id)->select('name', 'profile_pic')->get();
            $input['user_id'] = $target_id;
            $input['status'] = "banned";
            $input['admin_id'] = $admin['id'];
            $input['name'] = $user[0]->name;
            $input['profile_pic'] = $user[0]->profile_pic;
            $data['banned-user'] = ban::create($input);
            $massage = __('api.user_banned');
            return $this->successResponse($data,$massage);
        }
        else{
            $massage = __('api.not_authorized');
            return $this->errorResponse($massage);
        }
    }

    // un-ban user
    public function remove(Request $request){
        if(!$request->has('user_id')){
            $massage = __('api.missing_user');
            return $this->errorResponse($massage);
        }
        $check = ban::where('user_id' , $request->input('user_id'))->where('status', "banned")->first();
        if(!$check){
            $massage = __('api.not_banned_user');
            return $this->errorResponse($massage);
        }
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $target_id = $request->input('user_id');
            $sql = ban::where('user_id' ,$target_id)->where('status', "banned")->first();
            if($sql) {
                $message = __('api.unbanned');
                $sql->delete();
                return $this->successResponse(null, $message);

            }
        }
        else{
            $massage = __('api.not_authorized');
            return $this->errorResponse($massage);
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
