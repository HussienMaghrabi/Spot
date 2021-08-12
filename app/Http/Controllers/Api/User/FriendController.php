<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend_relation;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Support\Facades\Validator;
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
        $data = User::whereIn('id', array_merge($array1, $array2))->select('id','name','profile_pic as image')->paginate(15);


        return $this->successResponse($data);
    }

    // return count of user friends
    public function friendCount()
    {
        $auth = $this->auth();
        $array1 = Friend_relation::where('user_1', $auth)->where('is_added', 1)->pluck('user_2')->toArray();
        $array2 = Friend_relation::where('user_2', $auth)->where('is_added', 1)->pluck('user_1')->toArray();
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
            $message = __('api.friend_request');
            return $this->successResponse($data, $message);
        }
        else{ // friends already
            if($count1 != 0) {
                if($query[0]->is_added == 0){
                    $message = __('api.friend_requested_already');
                    return $this->successResponse([],$message);
                }
                else{
                    $message = __('api.already_friend');
                    return $this->successResponse([],$message);
                }
            }
            elseif ($count2 != 0) {
                if($query2[0]->is_added == 0){
                    $message = __('api.have_friend_request');
                    return $this->successResponse([],$message);
                }
                else{
                    $message = __('api.already_friend');
                    return $this->successResponse([],$message);
                }
            }
        }
    }
    // accept friend request
    public function acceptRequest(Request $request)
    {
        $auth = $this->auth();
        $record_id = $request->input('record_id');
        $query = Friend_relation::where('user_2' , $auth)->where('id' , $record_id)->get();
        $count = count($query);
        if($count != 0){
            if($query[0]->is_added == 1){
                $message = __('api.already_friend');
                return $this->successResponse([],$message);
            }
            else{
                $finalmsg = __('api.friend_request_accepted');
                $return_data = [];
                Friend_relation::where('id' , $record_id)->where('user_2' , $auth)->update(['is_added' => 1 ]);
                $checkBadge = $this->badgesForAddingFriends($auth);
                if($checkBadge != null){
                    $second_msg = __('api.receive_badge');
                    $return_data = $checkBadge;
                    $finalmsg = $finalmsg ." ". $second_msg;
                }
                $this->badgesForAddingFriends($query[0]->user_1);
                return $this->successResponse($return_data,$finalmsg);
            }
        }
    }


    public function badgesForAddingFriends($id)
    {
        $count =  $this->friendById($id);
        $data = Badge::where('category_id',10)->get();

        $badge_id = -1 ;
        foreach ($data as $item){
            if($count >= $item->amount){
                $badge_id =$item->id;
            }else{
                break;
            }

        }
        if ($badge_id != -1){
            $var = UserBadge::where('user_id',$id)->where('badge_id', $badge_id)->first();
            if (!$var){
                $input['user_id'] = $id;
                $input['badge_id'] = $badge_id ;
                UserBadge::create($input);
                $badge = Badge::where('id',$badge_id)->select('name','img_link as image')->get();
                return $badge;
            }
        }
    }


    public function friendById($id){
        $auth = $id;
        $array1 = Friend_relation::where('user_1', $auth)->where('is_added', 1)->pluck('user_2')->toArray();
        $array2 = Friend_relation::where('user_2', $auth)->where('is_added', 1)->pluck('user_1')->toArray();
        $count = count($array1) + count($array2);
        return $count;
    }

    // decline friend request
    public function declineRequest(Request $request)
    {
        $auth = $this->auth();
        $record_id = $request->input('record_id');
        $query = Friend_relation::where('user_2' , $auth)->where('id' , $record_id)->get();
        $count = count($query);
        if($count != 0){
            if($query[0]->is_added == 0){
                $sql = Friend_relation::where('id' ,$record_id)->first();
                if($sql){
                    $message = __('api.declined_friend_request');
                    $sql->delete();
                    return $this->successResponse(null,$message);
                }
            }else{
                $message = __('api.already_friend');
                return $this->successResponse(null,$message);

            }
        }else{
            $message = __("api.no_friend_request");
            return $this->successResponse(null,$message);
        }
    }

    // show friend requests list
    public function showRequests()
    {
        $auth = $this->auth();
        $query = Friend_relation::where('is_added' , 0)->where('user_2' , $auth)->select('id','user_1')->paginate(15);
        $count = count($query);
        if($count > 0){
            for($it =0; $it < $count; $it++){
                $data = User::where('id', $query[$it]->user_1)->select('name' , 'profile_pic as image')->get();
                $query[$it]->name = $data[0]->name;
                $query[$it]->image = $data[0]->image;
            }
            return $this->successResponse($query,__('api.Friend_requests_list'));
        }else{
            $message = __("api.no_friend_requests");
            return $this->successResponse([],$message);
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
                    $message = __('api.unfriend_user');
                    $sql->delete();
                    return $this->successResponse(null,$message);

                }
            }
            else{
                $target = $array2[0];
                $sql = Friend_relation::where('id' ,$target->id)->first();
                if($sql) {
                    $message = __('api.unfriend_user');
                    $sql->delete();
                    return $this->successResponse(null,$message);

                }
            }
        }
        else{
            $message = __("api.Not_Friend");
            return $this->successResponse(null,$message);
        }


    }

    public function rejectAll(){
        $auth = $this->auth();
        $query = Friend_relation::where('user_2', $auth)->where('is_added' , 0)->delete();
        $message = __("api.allRejected");
        return $this->successResponse([],$message);
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
