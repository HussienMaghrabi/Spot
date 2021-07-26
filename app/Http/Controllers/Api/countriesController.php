<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\country;
use DB;

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
            if ($country) {
                $message = __('api.completeAddSuccessfully');
                return $this->successResponse($data , $message);
            }else{
                $message = __('api.savaing not complete');
                return $this->errorResponse($data);
            }
            $validator = Validator::make(request()->all(), $rules);
            if($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            DB::beginTransaction();
            } catch (\Exception $e) {
                DB::rollback();
                return $this->errorResponse($e);
        }
    }
}
