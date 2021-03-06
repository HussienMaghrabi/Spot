<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\country;
use DB;
use App\Models\User;

class countriesController extends Controller
{
    public function index(Request $request)
    {
        $query = country::all();//country
        return $this->successResponse($query);
    }

    public function store(Request $request)
    {
        $data = array();
        DB::beginTransaction();
        try {
            $rules =  [
                'name' => 'required|unique:contries,name',
                'flag' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $data['name'] = $request->input('name');
            $data['flag'] = $request->input('flag');
            $data['lat'] = $request->input('lat');
            $data['long'] = $request->input('long');
            $country = country::create($data);
            if (!$country) {
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
                'flag' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $data['name'] = $request->input('name');
            $data['flag'] = $request->input('flag');
            $data['lat'] = $request->input('lat');
            $data['long'] = $request->input('long');
            $country = country::where('id',$id)->update($data);
            if (!$country) {
                $message = __('api.Updated not complete');
                return $this->errorResponse($message);
            }
            $message = __('api.completeUpdatedSuccessfully');
            return $this->successResponse($data , $message);
            DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return $this->errorResponse($e);
            }
    }
    public function destroy($id){
        // return response()->json($id, 200);
        DB::beginTransaction();
        $message = "";
        if(!country::where('id',$id)->first()){
            $message = __('api.CountryNotFound');
            return $this->errorResponse($message);
        }
        try {
            if (User::where('country_id',$id)->count() > 0) {
                $message = __('api.this country has users');
                return $this->errorResponse($message);
            }
            $data = country::where('id',$id)->delete();
            $message = __('api.Deleted complete');
            DB::commit();
            return $this->successResponse($data , $message);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e);
        }
    }
}
