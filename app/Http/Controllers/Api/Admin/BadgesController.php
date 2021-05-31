<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if ($admin){
            $data = Badge::orderBy('category_id', 'DESC')->get();
            return $this->successResponse($data,null);
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if ($admin){
            $data = Badge::where('id', $id)->first();
            return $this->successResponse($data);
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
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
        $admin = Admin::where('api_token', request()->header('Authorization'))->first();
        if($admin) {
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

            $input = request()->except('img_link');
            $item = Badge::find($id);
            if (request('img_link'))
            {
                if (strpos($item->img_link, '/uploads/') !== false) {
                    $image = str_replace( asset('').'storage/', '', $item->img_link);
                    Storage::disk('public')->delete($image);
                }
                $input['img_link'] = $this->uploadFile(request('img_link'), 'Badges');
            }
            $item->update($input);
            $data = Badge::where('id', $id)->select('id', 'name', 'img_link',  'amount',  'description')->first();
            return $this->successResponse($data, __('api.Updated'));
        }else{
            return $this->errorResponse(__('api.notAdmin'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Badge::findOrFail($id);
        if($data->image){
            $path = parse_url($data->image);
            unlink(public_path($path['path']));
        }
        $data->delete();
        $message = __('api.Deleted');
        return $this->successResponse(null, $message);
    }
}
