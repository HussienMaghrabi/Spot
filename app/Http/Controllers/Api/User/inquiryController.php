<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\InquiryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class inquiryController extends Controller
{
    public function getInquiryCats(){
        $data = InquiryCategory::all();
        if($data === null){
            $message = __('api.ItemNotFound');
            return $this->errorResponse($message, []);
        }else{
            $message = __('api.success');
            return $this->successResponse($data, $message);
        }
    }
    public function createInquiry(Request $request){
        $auth = $this->auth();
        $rules = [
            'inquiry_cat' => 'required',
            'desc' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $input['user_id'] = $auth;
        $input['inq_cat'] = $request->input('inquiry_cat');
        $input['desc'] = $request->input('desc');
        if (request('problem_img'))
        {
            $input['problem_img'] = $this->uploadFile(request('problem_img'), 'users'.$auth);
        }
        $inq = Inquiry::Create($input);
        if($inq === null){
            $message = __('api.no');
            return $this->errorResponse($message, []);
        }
        else{
            $record_id = $inq->id;
            $data = Inquiry::where('id', $record_id)->select('id', 'desc', 'problem_img as image')->get();
            $message = __('api.success');
            return $this->successResponse($data, $message);
        }
    }
}
