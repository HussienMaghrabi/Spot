<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Block_relation;
use App\Models\Follow_relation;
use App\Models\Friend_relation;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function blockList()
    {
        //
        $auth = $this->auth();
        $array = Block_relation::where('user_1', $auth)->pluck('user_2')->toArray();
        $data = User::whereIn('id', $array)->select('id','name','profile_pic')->paginate(15);
        return $this->successResponse($data);


    }

    // return count of blocked users by single user
    public function blockCount()
    {
        $auth = $this->auth();
        $array = Block_relation::where('user_1', $auth)->pluck('user_2')->toArray();
        $count = count($array);
        return $this->successResponse($count);
    }



    // add a block relation between user and another user
    public function create(Request $request){

        $auth = $this->auth();
        $id = $request->input('user_2');
        $query = Block_relation::where('user_2' , $id)->where('user_1' , $auth)->pluck('id');
        $count = count($query);
        if($count == 0) { // there is no block relation

            $rules = [
                'user_2' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $input = $request->all();

            $input['user_1'] = $auth;
            $data['blocked-user'] = Block_relation::create($input);

            // remove friend connection if there
            $query2 = Friend_relation::where('user_2' , $id)->where('user_1' , $auth)->pluck('id');
            $query3 = Friend_relation::where('user_2' , $auth)->where('user_1' ,$id )->pluck('id');
            $count2 = count($query2);
            $count3 = count($query3);
            if($count2 != 0){
//                $input2['user_1'] = $auth;
//                $input2['user_2'] = $id;
                $sql = Friend_relation::where('id' ,$query2)->first();
                if($sql) {
                    $sql->delete();
                }
            }
            elseif ($count3 != 0){
//                $input2['user_1'] = $id;
//                $input2['user_2'] = $auth;
                $sql4 = Friend_relation::where('id' ,$query3)->first();
                if($sql4) {
                    $sql4->delete();
                }
            }

            // remove follow & follower relation
            $query4 = Follow_relation::where('user_1' , $auth)->where('user_2' , $id)->pluck('id');
            $count4 = count($query4);
            if($count4 != 0){
                $sql2 = Follow_relation::where('id' ,$query4)->first();
                if($sql2) {
                    $sql2->delete();
                }
            }

            $query5 = Follow_relation::where('user_1' , $id)->where('user_2' , $auth)->pluck('id');
            $count5 = count($query5);
            if($count5 != 0){
                $sql3 = Follow_relation::where('id' ,$query5[0])->first();
                if($sql3) {
                    $sql3->delete();
                }
            }

            $message = __('api.blocked user');
            return $this->successResponse($data, $message);
        }else{ // already blocked user
            $message = __('api.already_blocked');
            return $this->successResponse(null,$message);
        }
    }

    // remove block between two users
    public function destroy(Request $request){

        $auth = $this->auth();
        $id = $request->input('user_2');
        $query = Block_relation::where('user_2' , $id)->where('user_1' , $auth)->pluck('id');
        //dd($query);
        $count = count($query);

        if($count == 0) {
            $message = __('api.no_block');
            return $this->successResponse(null,$message);
        }else{

            $rules =[
                'user_2' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $target = $query[0];
            $sql = Block_relation::where('id' ,$target)->first();
            if($sql) {
                $message = __('api.unblocked');
                $sql->delete();
                return $this->successResponse(null, $message);

            }
        }

    }


}
