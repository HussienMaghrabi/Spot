<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Event::orderBy('id', 'DESC')->select('id','title','desc','image','url','start_date','end_date')->paginate(15);
        return $this->successResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $data = Event::where('id', $id)->select('id','title','desc','image','url','start_date','end_date')->first();
        return $this->successResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = $this->authAdmin();
        if ($admin){
            $rules = [
                'title' => 'required',
                'desc' => 'required',
                'image' => 'nullable',
                'url' => 'required',
                'start_date' => 'required',
                'end_date' => 'required'
            ];

            $validator = Validator::make(request()->all(), $rules);
            if($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $input = $request->except('image');
            if( $request->image) {
                $input['image'] = $this->uploadFile(request('image'), 'events');
            }

            Event::create($input);
            $massage = __('api.created');
            return $this->successResponse(null,$massage);
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
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
        $admin = $this->authAdmin();
        if ($admin) {
            $rules = [
                'title' => 'required',
                'desc' => 'required',
                'image' => 'nullable',
                'url' => 'required',
                'start_date' => 'required',
                'end_date' => 'required'
            ];

            $validator = Validator::make(request()->all(), $rules);
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $input = request()->except('image');
            $item = Event::find($id);

            if (request('image'))
            {
                if (strpos($item->profile_pic, '/uploads/') !== false) {
                    $image = str_replace( asset('').'storage/', '', $item->image);
                    Storage::disk('public')->delete($image);
                }
                $input['image'] = $this->uploadFile(request('image'), 'events'.$id);
            }

            $item->update($input);

            $data = Event::where('id', $id)->select('id','title','desc','image','url','start_date','end_date')->first();
            return $this->successResponse($data, __('api.Updated'));
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
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
        $admin = $this->authAdmin();
        if ($admin) {
            $data = Event::findOrFail($id);
            $data->delete();
            $message = __('api.Deleted');
            return $this->successResponse(null, $message);
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }

    }
}
