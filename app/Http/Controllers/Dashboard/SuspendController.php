<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\adminAction;
use App\Models\ban;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class SuspendController extends Controller
{
    private $resources = 'suspends';
    private $resource = [
        'route' => 'admin.suspends',
        'view' => "suspends",
        'icon' => "times",
        'title' => "SUSPENDS",
        'action' => "",
        'header' => "Suspends"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // show list of banned users
    public function index()
    {
        $data = ban::where('status' , 'suspended')->select('id','status', 'name' ,'admin_id','user_id','num_of_days')->paginate(15);
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
            'special_id' => 'nullable',
            'email' => 'nullable|email',
            'desc' => 'nullable',
            'num_of_days' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $user = User::where('special_id',$request->special_id)->orWhere('email',$request->email)->first();
        $check = ban::where('user_id' , $user->id)->where('status', "banned")->first();
        if($check){
            $massage = __('api.already_banned_user');
            flashy()->error($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
        }else{
            $target_id = $user->id;
            $input['user_id'] = $target_id;
            $input['status'] = "suspended";
            $input['admin_id'] =  Auth::guard('admin')->user()->id;
            $input['name'] = $user->name;
            $input['profile_pic'] = $user->profile_pic;
            $input['num_of_days'] = $request->num_of_days;
            $data['banned-user'] = ban::create($input);

            adminAction::create([
                'admin_id'=> Auth::guard('admin')->user()->id,
                'target_user_id'=> $target_id,
                'action'=> "suspended",
                'desc'=> $request->desc,
            ]);

            $massage = __('api.user_banned');
            flashy($massage);
            return redirect()->route($this->resource['route'].'.index', $lang);
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
            'action'=> "Unsuspend",
        ]);
        ban::findOrFail($id)->delete();
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

}
