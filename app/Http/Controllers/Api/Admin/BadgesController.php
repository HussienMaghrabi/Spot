<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BadgesController extends Controller
{
    //

    public function addFriendBadge(Request $request)
    {
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if ($admin){
            $rules = [
                'name' => 'required',
                'img_link' => 'required',
                'amount' => 'required',
                'description' => 'required',
            ];
            $validator = Validator::make(request()->all(), $rules);
            if($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $input = $request->except('img_link');
            if( $request->img_link) {
                $input['img_link'] = $this->uploadFile(request('img_link'), 'badges');
            }
            $input['category_id'] = 1;
            $data = Badge::create($input);
            return $this->successResponse($data);
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
    }
}
