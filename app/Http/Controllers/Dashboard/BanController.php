<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\adminAction;
use App\Models\ban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Validator;
use Auth;

class BanController extends Controller
{
    private $resources = 'bans';
    private $resource = [
        'route' => 'admin.bans',
        'view' => "bans",
        'icon' => "ban",
        'title' => "BANS",
        'action' => "",
        'header' => "Bans"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // show list of banned users
    public function index()
    {
        $data = ban::where('status' , 'banned')->select('id','status', 'name' ,'admin_id','user_id')->paginate(15);
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
        App::setLocale($lang);
        $rules =  [
            'special_id' => 'nullable',
            'email' => 'nullable|email',
            'mobile_id' => 'nullable',
            'desc' => 'nullable',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $user = User::where('special_id',$request->special_id)->orWhere('email',$request->email)->first();
        if ($request->mobile_id){
            $users = User::where('mobile_id',$request->mobile_id)->pluck('id')->toArray();

            foreach ($users as $value){
                $check = ban::where('user_id' , $value)->where('status', "banned")->first();
                $user = User::where('id',$value)->first();
                if(!$check){
                    $target_id = $value;
                    $input['user_id'] = $target_id;
                    $input['status'] = "banned";
                    $input['admin_id'] =  Auth::guard('admin')->user()->id;
                    $input['name'] = $user->name;
                    $input['profile_pic'] = $user->profile_pic;
                    $data['banned-user'] = ban::create($input);

                    adminAction::create([
                        'admin_id'=> Auth::guard('admin')->user()->id,
                        'target_user_id'=> $target_id,
                        'action'=> "banned",
                        'desc'=> $request->desc,
                    ]);

                }
            }
            $massage = __('api.user_banned');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }else{
            $check = ban::where('user_id' , $user->id)->where('status', "banned")->first();
            if($check){
                $massage = __('api.already_banned_user');
                flashy()->error($massage);
                return redirect()->route($this->resource['route'].'.index', $lang);
            }else{
                $target_id = $user->id;
                $input['user_id'] = $target_id;
                $input['status'] = "banned";
                $input['admin_id'] =  Auth::guard('admin')->user()->id;
                $input['name'] = $user->name;
                $input['profile_pic'] = $user->profile_pic;
                $data['banned-user'] = ban::create($input);

                adminAction::create([
                    'admin_id'=> Auth::guard('admin')->user()->id,
                    'target_user_id'=> $target_id,
                    'action'=> "banned",
                    'desc'=> $request->desc,
                ]);

                $massage = __('api.user_banned');
                flashy($massage);
                return redirect()->route($this->resource['route'].'.index', $lang);
            }
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        $ban= ban::where('id',$id)->first();
        adminAction::create([
            'admin_id'=> Auth::guard('admin')->user()->id,
            'target_user_id'=> $ban->user_id,
            'action'=> "Unban",
        ]);
        ban::findOrFail($id)->delete();
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function multiDelete($lang)
    {
        App::setLocale($lang);
        foreach (\request('checked') as $id)
        {
            $item = ban::findOrFail($id);
            $item->delete();
        }

        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }



    public function search(Request $request,$lang)
    {
        App::setLocale($lang);
        $resource = $this->resource;
        $data = ban::select('bans.id','bans.name','bans.user_id', 'bans.admin_id', 'bans.profile_pic', 'bans.status')
            ->join('users', 'users.id', '=', 'bans.user_id')
            ->join('admins', 'admins.id', '=', 'bans.admin_id')
            ->Where('users.special_id', 'LIKE', '%'.$request->text.'%')
            ->orWhere('users.email', 'LIKE', '%'.$request->text.'%')
            ->orWhere('users.mobile_id', 'LIKE', '%'.$request->text.'%')
            ->orWhere('bans.name', 'LIKE', '%'.$request->text.'%')
            ->orWhere('bans.status', 'LIKE', '%'.$request->text.'%')
            ->orWhere('admins.name', 'LIKE', '%'.$request->text.'%')
            ->orWhere('admins.email', 'LIKE', '%'.$request->text.'%')
            ->paginate(10);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }
}
