<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\adminAction;
use App\Models\Room;
use App\Models\RoomMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use \Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    private $resources = 'rooms';
    private $resource = [
        'route' => 'admin.rooms',
        'view' => "rooms",
        'icon' => "desktop",
        'title' => "ROOMS",
        'action' => "",
        'header' => "Rooms"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // show list of banned users
    public function index()
    {
        $data = Room::orderBy('id')->paginate(10);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($lang,$id)
    {
        $data = Room::where('id',$id)->first();
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.show',compact('data', 'resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id,$iid)
    {
        $resource = $this->resource;
        $resource['action'] = 'Edit';
        $item = Room::findOrFail($id);
        return view('dashboard.views.' .$this->resources. '.edit', compact('item', 'resource','iid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        App::setLocale($lang);
        $rules =  [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $item = Room::find($id);
        $inputs = $request->except('main_image' );
        if (request('main_image'))
        {

            if (strpos($item->main_image, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->main_image);
                Storage::disk('public')->delete($image);
            }
            $inputs['main_image'] = $this->uploadFile(request('main_image'), 'rooms'.$id);
//            dd($auth);
        }
        $item->update($inputs);

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function change_name(Request $request, $lang,$id)
    {
        App::setLocale($lang);
        $resource = $this->resource;
        $target_room = $id;
        $room = Room::where('id', $target_room)->first();
        if($room === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }
        $name = request('name');
        Room::where('id', $target_room)->update(['name' => $name]);

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_room_id'=> $target_room,
            'action'=> "Change name",
            'desc'=> $request->desc,
        ]);

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function change_image(Request $request, $lang,$id)
    {
        App::setLocale($lang);
        $resource = $this->resource;
        $room = Room::where('id', $id)->first();
        if($room === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }
        if (request('main_image'))
        {

            if (strpos($room->main_image, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $room->main_image);
                Storage::disk('public')->delete($image);
            }
            $inputs['main_image'] = $this->uploadFile(request('main_image'), 'rooms'.$id);
        }

        $room->update($inputs);

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_room_id'=> $id,
            'action'=> "Change Image",
            'desc'=> $request->desc,
        ]);

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function pinRoom(Request $request, $lang,$id)
    {
        App::setLocale($lang);
        $room = Room::where('id', $id)->first();
        if($room === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }
        $pinned = request('pinned');
        Room::where('id', $id)->update(['pinned' => $pinned]);

        if ($pinned == 1){
            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_room_id'=> $id,
                'action'=> "pin Room",
                'desc'=> $request->desc,
            ]);
        }else{
            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_room_id'=> $id,
                'action'=> "unpin Room",
                'desc'=> $request->desc,
            ]);
        }

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function trendRoom(Request $request, $lang,$id)
    {
        App::setLocale($lang);
        $room = RoomMember::where('room_id', $id)->first();
        if($room === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }
        $trend = request('trend');
        RoomMember::where('room_id', $id)->update(['trend' => $trend]);

        if ($trend == 1){
            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_room_id'=> $id,
                'action'=> "trend Room",
                'desc'=> $request->desc,
            ]);
        }else{
            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_room_id'=> $id,
                'action'=> "un trend Room",
                'desc'=> $request->desc,
            ]);
        }

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function officialRoom(Request $request, $lang,$id)
    {
        App::setLocale($lang);
        $room = RoomMember::where('id', $id)->first();
        if($room === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }
        $official = request('official');
        RoomMember::where('id', $id)->update(['official' => $official]);

        if ($official == 1){
            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_room_id'=> $id,
                'action'=> "official Room",
                'desc'=> $request->desc,
            ]);
        }else{
            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_room_id'=> $id,
                'action'=> "un official Room",
                'desc'=> $request->desc,
            ]);
        }

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

}
