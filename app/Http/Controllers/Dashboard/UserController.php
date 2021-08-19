<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;
use Auth;

class UserController extends Controller
{
    private $resources = 'users';
    private $resource = [
        'route' => 'admin.users',
        'view' => "users",
        'icon' => "users",
        'title' => "USERS",
        'action' => "",
        'model' => "User",
        'header' => "Users"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('id', 'DESC')->whereNull('vip_role')->paginate(10);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = $this->resource;
        $resource['action'] = 'Create';
        return view('dashboard.views.'.$this->resources.'.create',compact( 'resource'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lang)
    {
        $rules =  [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users',
            'image' => 'required|mimes:jpeg,jpg,png,gif',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $inputs = $request->except('image');
        if ($request->image)
        {
            $inputs['image'] =$this->uploadFile($request->image, 'users');
        }

        User::create($inputs);
        App::setLocale($lang);
        flashy(__('dashboard.created'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($lang,$id)
    {
        $data = User::where('id',$id)->first();
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
        $item = User::findOrFail($id);
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
        $rules =  [
            'name' => 'nullable',
            'special_id' => 'nullable',
            'gender' => 'nullable',
            'coins' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $item = User::find($id);
        $inputs = $request->except('special_id','coins');


        if(request('special_id') != null){
            $inputs['special_id'] = request('special_id');
        }else{
            $inputs['special_id'] = Str::random(9);
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
        User::findOrFail($id)->delete();
        return redirect()->route($this->resource['route'].'.index', $lang);
    }


    public function multiDelete($lang)
    {
        App::setLocale($lang);
        foreach (\request('checked') as $id)
        {
            $item = User::findOrFail($id);
            if (strpos($item->image, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->image);
                Storage::disk('public')->delete($image);
            }
            $item->delete();
        }

        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function search(Request $request)
    {
        $resource = $this->resource;
        $data = User::where('name', 'LIKE', '%'.$request->text.'%')
            ->orWhere('email', 'LIKE', '%'.$request->text.'%')
            ->orWhere('special_id', 'LIKE', '%'.$request->text.'%')
            ->paginate(10);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit_name($lang, $id)
    {
        $resource = $this->resource;
        $resource['action'] = 'Edit';
        $item = User::findOrFail($id);
        return view('dashboard.views.' .$this->resources. '.change_name', compact('item', 'resource'));
    }

    public function change_name(Request $request, $lang,$id)
    {
        $resource = $this->resource;
        $target_user = $id;
        $user = User::where('id', $target_user)->first();
        if($user === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }
        $name = request('name');
        $user = User::where('id', $target_user)->update(['name' => $name]);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function change_special_id(Request $request, $lang,$id)
    {
        $resource = $this->resource;
        $target_user = $id;
        $user = User::where('id', $target_user)->first();
        if($user === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }
        if(request('special_id') != null){
            $special_id['special_id'] = request('special_id');
        }else{
            $special_id['special_id'] = Str::random(9);
        }
        $user = User::where('id', $target_user)->update(['special_id' => $special_id]);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function change_gender(Request $request, $lang,$id)
    {
        $resource = $this->resource;
        $target_user = $id;
        $user = User::where('id', $target_user)->first();
        if($user === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }

        $gender = request('gender');

        $user = User::where('id', $target_user)->update(['gender' => $gender]);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

}
