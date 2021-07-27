<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\category;
use DB;
use App\Models\User;

class categoriesController extends Controller
{
    public function index(Request $request)
    {
        $query = category::all(); //category
        return $this->successResponse($query);
    }

    public function store(Request $request)
    {
        $data = array();
        DB::beginTransaction();
        try {
            $rules =  [
                'name' => 'required|unique:categories,name',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $data['name'] = $request->input('name');
            $data['description'] = $request->input('description');
            $data['color'] = $request->input('color');
            $category = category::create($data);
            if (!$category) {
                $message = __('api.savaing not complete');
                return $this->errorResponse($message);
            }
            $message = __('api.completeAddSuccessfully');
            DB::commit();
            return $this->successResponse($data , $message);
            } catch (\Exception $e) {
                DB::rollback();
                return $this->errorResponse($e);
        }
    }
    public function update(Request $request, $id)
    {
        $data = array();   
        DB::beginTransaction();
        try {
            $rules =  [
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $data['name'] = $request->input('name');
            $data['description'] = $request->input('description');
            $data['color'] = $request->input('color');
            $category = category::where('id',$id)->update($data);
            if (!$category) {
                $message = __('api.Updated not complete');
                return $this->errorResponse($message);
            }
            $message = __('api.completeUpdatedSuccessfully');
            DB::commit();
            return $this->successResponse($data , $message);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e);
        }
    }

    public function destroy($id){
        // return response()->json($id, 200);
        DB::beginTransaction();
        $message = "";
        if(!category::where('id',$id)->first()){
                $message = __('api.categoryNotFound');
                return $this->errorResponse($message);
            }
            // for any validation
        try {
            // if (User::where('category_id',$id)->count() > 0) {
            //     $message = __('api.this category has users');
            //     return $this->errorResponse($message);
            // }
            $data = category::where('id',$id)->delete();
            $message = __('api.Deleted complete');
            DB::commit();
            return $this->successResponse($data , $message);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e);
        }
    }
}
