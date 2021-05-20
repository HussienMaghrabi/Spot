<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend_relation;
use phpDocumentor\Reflection\Types\Integer;
use Validator;
use Http;


class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $auth = $this->auth();

        $array1 = Friend_relation::where('user_1', $auth)->where('is_added',1)->pluck('user_2')->toArray();
        $array2 = Friend_relation::where('user_2', $auth)->where('is_added',1)->pluck('user_1')->toArray();
        $data = User::whereIn('id', array_merge($array1, $array2))->select('id','name','profile_pic')->get();


        return $this->successResponse($data);
    }

    // return count of user friends
    public function friendCount()
    {
        $auth = $this->auth();
        $array1 = Friend_relation::where('user_1', $auth)->pluck('user_2')->toArray();
        $array2 = Friend_relation::where('user_2', $auth)->pluck('user_1')->toArray();
        $count = count($array1) + count($array2);
        return $this->successResponse($count);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $auth = $this->auth();
        $id = $request->input('user_2');
        $query = Friend_relation::where('user_1' , $auth)->where('user_2' , $id)->get();
        $query2 = Friend_relation::where('user_1' , $id)->where('user_2' , $auth)->get();
        $count1 = count($query);
        $count2 = count($query2);
        if(($count1 + $count2) == 0 ){ // not friends
            $rules = [
                'user_2' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $input = $request->all();
            $input['user_1'] = $auth;
            $input['is_added'] = 0;
            $data['friend-request-sent'] = Friend_relation::create($input);
            $message = __('followed user');
            return $this->successResponse($data, $message);
        }
        else{ // friends already
            if($count1 != 0) {
                if($query[0]->is_added == 0){
                    $message = __('friend request sent');
                    return $this->successResponse($message);
                }
                else{
                    $message = __('already a friend');
                    return $this->successResponse($message);
                }
            }
            elseif ($count2 != 0) {
                if($query2[0]->is_added == 0){
                    $message = __('friend request sent');
                    return $this->successResponse($message);
                }
                else{
                    $message = __('already a friend');
                    return $this->successResponse($message);
                }
            }
        }
    }
    // accept friend request
    public function acceptRequest(Request $request)
    {
        $auth = $this->auth();
        $record_id = $request->input('record_id');
        $query = Friend_relation::where('user_1' , $auth)->where('id' , $record_id)->get();
        $count = count($query);
        if($count != 0){
            if($query[0]->is_added == 1){
                $message = __('already a friend');
                return $this->successResponse($message);
            }
            else{
                Friend_relation::where('id' , $record_id)->where('user_1' , $auth)->update(['is_added' => 1 ]);
                $message = __('friend request accepted');
                return $this->successResponse($message);
            }
        }
    }

    // decline friend request
    public function declineRequest(Request $request)
    {
        $auth = $this->auth();
        $record_id = $request->input('record_id');
        $query = Friend_relation::where('user_1' , $auth)->where('id' , $record_id)->get();
        $count = count($query);
        if($count != 0){
            if($query[0]->is_added == 0){
                $sql = Friend_relation::where('id' ,$record_id)->first();
                if($sql){
                    $message = __('declined friend request');
                    $sql->delete();
                    return $this->successResponse($message);
                }
            }else{
                $message = __('this user is already a friend');
                return $this->successResponse($message);

            }
        }else{
            $message = __("couldn't find friend request");
            return $this->successResponse($message);
        }
    }

    // show friend requests list
    public function showRequests()
    {
        $auth = $this->auth();
        $query = Friend_relation::where('is_added' , 0)->where('user_1' , $auth)->select('id','user_2')->get();
        $count = count($query);
        if($count > 0){
            for($it =0; $it < $count; $it++){
                $data = User::where('id', $query[$it]->user_2)->select('name' , 'profile_pic')->get();
                $query[$it]->name = $data[0]->name;
                $query[$it]->profile_pic = $data[0]->profile_pic;
            }
            return $this->successResponse($query,'Friend requests list');
        }else{
            $message = __("You have no friend requests now");
            return $this->successResponse($message);
        }
    }
    // unfriend user
    public function unFriend(Request $request)
    {
        $rules =[
            'user_2' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $auth = $this->auth();
        $id = $request->input('user_2');
        $array1 = Friend_relation::where('user_1', $auth)->where('user_2', $id)->where('is_added',1)->get();
        $array2 = Friend_relation::where('user_2', $auth)->where('user_1', $id)->where('is_added',1)->get();
        $count1 = count($array1);
        $count2 = count($array2);
        if($count1 > 0 || $count2 > 0){
            $object = new FollowController();
            $object->unfollow($request);

            if($count1 > 0){

                $target = $array1[0];
                $sql = Friend_relation::where('id' ,$target->id)->first();
                if($sql) {
                    $message = __('unfriend user');
                    $sql->delete();
                    return $this->successResponse($message);

                }
            }
            else{
                $target = $array2[0];
                $sql = Friend_relation::where('id' ,$target->id)->first();
                if($sql) {
                    $message = __('unfriend user');
                    $sql->delete();
                    return $this->successResponse($message);

                }
            }
        }
        else{
            $message = __("Not A Friend");
            return $this->successResponse($message);
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
