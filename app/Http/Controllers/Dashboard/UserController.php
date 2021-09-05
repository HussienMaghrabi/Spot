<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\adminAction;
use App\Models\ChargingLevel;
use App\Models\Coins_purchased;
use App\Models\User;
use App\Models\User_Item;
use App\Models\userChargingLevel;
use App\Models\Vip_tiers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
        $vip = Vip_tiers::pluck('name', 'id')->all();
        return view('dashboard.views.'.$this->resources.'.create',compact( 'resource','vip'));

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
            'vip' => 'required',
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

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $target_user,
            'action'=> "Change name",
            'desc'=> $request->desc,
        ]);

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
            $special_id = request('special_id');
        }else{
            $special_id = Str::random(9);
        }
        $user = User::where('id', $target_user)->update(['special_id' => $special_id]);

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $target_user,
            'action'=> "Change special id",
            'desc'=> $request->desc,
        ]);

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

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $target_user,
            'action'=> "Change Gender",
            'desc'=> $request->desc,
        ]);


        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function rechargeNoLevel(Request $request, $lang,$id)
    {
        $rules = [
            'amount' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }
        $target_user = $id;
        $addedAmount = $request->input('amount');
        $user_coins = User::where('id', $target_user)->pluck('coins')->first();
        if ($user_coins === null) {
            $massage = __('api.userNotFound');
            flashy()->error($massage);
            return back();
        }
        $newCoins = $user_coins + $addedAmount;
        $user = User::where('id', $target_user)->update(['coins' => $newCoins]);

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $target_user,
            'action'=> "recharge without level up",
            'desc'=> $request->desc,
        ]);

        Coins_purchased::create([
            'status'=>'purchased',
            'amount'=>$addedAmount,
            'date_of_purchase'=>Carbon::now(),
            'user_id'=>$target_user,
            'admin_id'=>Auth::guard('admin')->user()->id,
        ]);

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function rechargeWithLevel(Request $request, $lang,$id){
        $rules = [
            'amount' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }
        $target_user = $id;
        $addedAmount = $request->input('amount');
        $user =User::where('id',$target_user)->first();
        $user_level = userChargingLevel::where('user_id',$target_user)->first();
        if($user_level === null){
            $arr['user_id'] = $target_user;
            $arr['coins'] = 0;
            $arr['user_level'] = 1;
            userChargingLevel::create($arr);
        }
        $user_level = userChargingLevel::where('user_id',$target_user)->first();
        $all_limit = ChargingLevel::where('levelNo', '>=', $user_level->user_level)->get();
        $size = count($all_limit);
        if($user_level){
            $old_coins = userChargingLevel::where('user_id',$target_user)->pluck('coins')->first();
            $new_coins = $old_coins + $addedAmount ;
            $old_level = $user_level->user_level;
            $new_level = $old_level;
            if($size != 1){
                foreach ($all_limit as $limit){
                    if($limit->level_limit <= $new_coins){
                        $new_level = $new_level +1;
                        break;
                    }
                }
            }
            userChargingLevel::where('user_id',$target_user)->update([
                'coins'=>$new_coins,
                'user_level'=>$new_level
            ]);
            $coins = $user->coins + $addedAmount;
            $user->update(['coins' => $coins]);
        }else{
            $old_coins = 0;
            $new_coins = $old_coins + $addedAmount ;
            $old_level = 1;
            $new_level = $old_level;
            foreach ($all_limit as $limit){
                if($limit->level_limit <= $new_coins){
                    $new_level = $new_level +1;
                }
                else{
                    break;
                }
            }
            userChargingLevel::create([
                'user_id'=>$target_user,
                'coins'=>$new_coins,
                'user_level'=>$new_level
            ]);
            $coins = $user->coins + $addedAmount;
            $user->update(['coins' => $coins]);
        }

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $target_user,
            'action'=> "recharge with level up",
            'desc'=> $request->desc,
        ]);

        Coins_purchased::create([
            'status'=>'purchased',
            'amount'=>$addedAmount,
            'date_of_purchase'=>Carbon::now(),
            'user_id'=>$target_user,
            'admin_id'=>Auth::guard('admin')->user()->id,
        ]);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);

    }

    public function reduceCoins(Request $request, $lang,$id)
    {
        $rules = [
            'amount' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $target_user = $id;
        $addedAmount = $request->input('amount');
        $user_coins = User::where('id', $target_user)->pluck('coins')->first();
        if ($user_coins === null) {
            $massage = __('api.userNotFound');
            flashy()->error($massage);
            return back();
        }
        $newCoins = $user_coins - $addedAmount;
        $user = User::where('id', $target_user)->update(['coins' => $newCoins]);

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $target_user,
            'action'=> "reduce Coins",
            'desc'=> $request->desc,
        ]);

        Coins_purchased::create([
            'status'=>'reduce Coins',
            'amount'=>$addedAmount,
            'date_of_purchase'=>Carbon::now(),
            'user_id'=>$target_user,
            'admin_id'=>Auth::guard('admin')->user()->id,
        ]);

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function reduceDiamond(Request $request, $lang,$id)
    {
        $rules = [
            'amount' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $target_user = $id;
        $addedAmount = $request->input('amount');
        $user_gems = User::where('id', $target_user)->pluck('gems')->first();
        if ($user_gems === null) {
            $massage = __('api.userNotFound');
            flashy()->error($massage);
            return back();
        }
        $newGems = $user_gems - $addedAmount;
        $user = User::where('id', $target_user)->update(['gems' => $newGems]);

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $target_user,
            'action'=> "reduce Diamond",
            'desc'=> $request->desc,
        ]);

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function change_image(Request $request, $lang,$id)
    {
        $resource = $this->resource;
        $user = User::where('id', $id)->first();
        if($user === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }

        if (request('profile_pic'))
        {

            if (strpos($user->main_image, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $user->main_image);
                Storage::disk('public')->delete($image);
            }
            $inputs['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users'.$id);
        }
        $user->update($inputs);

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $id,
            'action'=> "Change Image",
            'desc'=> $request->desc,
        ]);

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function vip(Request $request, $lang,$id){
        $rules =  [
            'vip_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $target_user = $id;
        $vip = request('vip_id');

        User::where('id', $target_user)->update(['vip_role' => $vip]);

        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $target_user,
            'action'=> "add vip role",
            'desc'=> $request->desc,
        ]);

        App::setLocale($lang);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);

    }

    public function user_items($lang,$id)
    {
        $data = User_Item::where('user_id',$id)->orderBy('is_activated', 'DESC')->paginate(10);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.item',compact('data', 'resource'));
    }

    public function freezeDiamond(Request $request, $lang,$id)
    {
        App::setLocale($lang);
        $user = User::where('id', $id)->first();
        if($user === null){
            $massage = __('api.userNotFound');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }
        $freeze = request('freeze');
        User::where('id', $id)->update(['freeze_gems' => $freeze]);

        if ($freeze == 1){
            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_user_id'=> $id,
                'action'=> "freeze Diamond",
                'desc'=> $request->desc,
            ]);
        }else{
            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_user_id'=> $id,
                'action'=> "un freeze Diamond",
                'desc'=> $request->desc,
            ]);
        }

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

}
