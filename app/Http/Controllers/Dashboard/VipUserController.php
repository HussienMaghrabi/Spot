<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\adminAction;
use App\Models\ChargingLevel;
use App\Models\Coins_purchased;
use App\Models\User;
use App\Models\User_Item;
use App\Models\userChargingLevel;
use App\Models\UserDiamondTransaction;
use App\Models\Vip_tiers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class VipUserController extends Controller
{
    private $resources = 'vip_users';
    private $resource = [
        'route' => 'admin.vip-users',
        'view' => "vip_users",
        'icon' => "user-circle",
        'title' => "VIP_USERS",
        'action' => "",
        'header' => "VipUsers"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('vip_role', 'DESC')->whereNotNull('vip_role')->paginate(10);
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
        $vip = Vip_tiers::pluck('name', 'id')->all();
        return view('dashboard.views.' .$this->resources. '.edit', compact('item', 'resource','iid','vip'));
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
        $auth = $this->auth();
        $rules =  [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
            'profile_pic' => 'nullable|mimes:jpeg,jpg,png,gif',
            'special_id' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $item = User::find($id);
        $inputs = $request->except('profile_pic' ,'special_id');

        if (request('profile_pic'))
        {

            if (strpos($item->profile_pic, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->profile_pic);
                Storage::disk('public')->delete($image);
            }
            $inputs['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users'.$id);
//            dd($auth);
        }

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

    public function search(Request $request,$lang)
    {
        App::setLocale($lang);
        $resource = $this->resource;
        $data = User::where('name', 'LIKE', '%'.$request->text.'%')
            ->orWhere('email', 'LIKE', '%'.$request->text.'%')
            ->orWhere('special_id', 'LIKE', '%'.$request->text.'%')
            ->orWhere('mobile_id', 'LIKE', '%'.$request->text.'%')
            ->paginate(10);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }

}
