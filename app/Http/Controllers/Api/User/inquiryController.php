<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\InquiryCategory;
use App\Models\InquiryImages;
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
            'images.*'    => 'nullable|image'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $input['user_id'] = $auth;
        $input['inq_cat'] = $request->input('inquiry_cat');
        $input['desc'] = $request->input('desc');
        $inq = Inquiry::Create($input);
        $sql = Inquiry::where('user_id', $auth)->orderByDesc('id')->select('id')->first();
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                InquiryImages::create([
                    'image' => $this->uploadFile($image, 'inquiry' . $auth),
                    'inq_id' => $sql->id
                ]);
            }
        }
        if($inq === null){
            $message = __('api.no');
            return $this->errorResponse($message, []);
        }
        else{
            $message = __('api.success');
            return $this->successResponse([], $message);
        }
    }
}
