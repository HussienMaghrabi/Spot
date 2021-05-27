<?php

namespace App\Http\Controllers\Api\accounts;

use App\Http\Controllers\Controller;
use App\Models\ban;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;

class SuspendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // show list of suspended users
    public function index()
    {
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $data = ban::where('status' , 'suspended')->select('id' , 'name' ,'profile_pic', 'num_of_days')->paginate(15);
        }
        return $this->successResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // suspend user by id for number of days
    public function create(Request $request)
    {
        if(!$request->has('user_id')){
            $massage = __('api.missing_user');
            return $this->errorResponse($massage);
        }
        $check = ban::where('user_id' , $request->input('user_id'))->where('status', "suspended")->first();
        if($check){
            $massage = __('api.already_suspended_user');
            return $this->errorResponse($massage);
        }

        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $target_id = $request->input('user_id');
            $user = User::where('id' , $target_id)->select('name', 'profile_pic')->get();
            $input['user_id'] = $target_id;
            $input['status'] = "suspended";
            $input['num_of_days'] = $request->input('days');
            $input['admin_id'] = $admin['id'];
            $input['name'] = $user[0]->name;
            $input['profile_pic'] = $user[0]->profile_pic;
            $data['banned-user'] = ban::create($input);
            $massage = __('api.user_suspended');
            return $this->successResponse($data,$massage);
        }
        else{
            $massage = __('api.not_authorized');
            return $this->errorResponse($massage);
        }

    }

    // un-suspend user
    public function remove(Request $request){
        if(!$request->has('user_id')){
            $massage = __('api.missing_user');
            return $this->errorResponse($massage);
        }
        $check = ban::where('user_id' , $request->input('user_id'))->where('status', "suspended")->first();
        if(!$check){
            $massage = __('api.not_suspended_user');
            return $this->errorResponse($massage);
        }
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin){
            $target_id = $request->input('user_id');
            $sql = ban::where('user_id' ,$target_id)->where('status', "suspended")->first();
            if($sql) {
                $message = __('api.unsuspended');
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
