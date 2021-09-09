<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Badge;
use App\Models\UserBadge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserBadgesController extends Controller
{
    private $resources = 'userBadges';
    private $resource = [
        'route' => 'admin.userBadges',
        'view' => "userBadges",
        'icon' => "id-badge",
        'title' => "BADGES",
        'action' => "",
        'model' => "Badges",
        'header' => "Badges"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang,$value)
    {
        $data = UserBadge::where('user_id',$value)->select('id','badge_id','user_id')->paginate(6);
        $data->map(function ($item){
            $item->badge = Badge::where('id',$item->id)->where('hidden',1)->get();
            $item->image = $item->badge[0]->img_link;
            $item->name = $item->badge[0]->name;

            unset($item->badge);
        });

        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource','value'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang, $value)
    {
        App::setLocale($lang);
        $resource = $this->resource;
        $resource['action'] = 'Create';
        $badges = Badge::where('hidden',1)->pluck('name', 'id')->all();
        return view('dashboard.views.'.$this->resources.'.create',compact( 'resource','value','badges'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,  $lang, $value)
    {
        $rules =  [
            'badge_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $inputs = $request->all();
        $inputs['user_id'] = $value;
        UserBadge::create($inputs);

        App::setLocale($lang);
        flashy(__('dashboard.created'));
        return redirect()->route($this->resource['route'].'.index', [$lang,$value]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserBadge  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $value, $id)
    {
        App::setLocale($lang);
        $item = UserBadge::findOrFail($id);
        $item->delete();
        return redirect()->route($this->resource['route'].'.index', [$lang, $value]);
    }

    public function multiDelete($lang, $value)
    {
        App::setLocale($lang);
        foreach (\request('checked') as $id)
        {
            $item = UserBadge::findOrFail($id);
            $item->delete();
        }

        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', [$lang, $value]);
    }
}
