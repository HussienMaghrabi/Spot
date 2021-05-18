<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Block_relation;
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
        $data = User::whereIn('id', $array)->select('id','name','profile_pic')->get();
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
        if($count == 0) {

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
            $message = __('blocked user');
            return $this->successResponse($data, $message);
        }else{
            $message = __('already blocked user');
            return $this->successResponse($message);
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
            $message = __('no block with user');
            return $this->successResponse($message);
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
                $message = __('unblocked user');
                $sql->delete();
                return $this->successResponse(null, $message);

            }
        }

    }


}
