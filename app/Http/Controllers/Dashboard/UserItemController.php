<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User_Item;
use Carbon\Carbon;
Use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserItemController extends Controller
{
    private $resources = 'userItems';
    private $resource = [
        'route' => 'admin.userItems',
        'view' => "userItems",
        'icon' => "picture-o",
        'title' => "USER_ITEMS",
        'action' => "",
        'header' => "UserItems",
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang, $value)
    {
        App::setLocale($lang);
        $data = User_Item::where('user_id', $value)->paginate(10);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource', 'value'));
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
        $categories = ItemCategory::select("name_$lang as name", 'id')->get();
        $item_id = Item::select("name", 'id')->where('cat_id', request('cat_id'))->get();
        return view('dashboard.views.'.$this->resources.'.create',compact( 'resource', 'value','categories','item_id'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lang, $value)
    {
        App::setLocale($lang);
        $rules =  [
            'item_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $item_id =  $request->item_id;
        $query = Item::where('id' , $item_id)->pluck('duration');
        $duration = $query[0];
        $target_id = $value;
        $item = User_Item::where('item_id', $item_id)->where('user_id' , $target_id)->pluck('item_id')->first();
        if(!$item){
            $mutable = Carbon::now();
            $modifiedMutable = $mutable->add($duration, 'day');
            $input['user_id'] = $target_id;
            $input['item_id'] = $item_id;
            $input['is_activated'] = 0;
            $input['time_of_exp'] = $modifiedMutable->isoFormat('Y-MM-DD');
            User_Item::create($input);

            flashy(__('dashboard.created'));
            return redirect()->route($this->resource['route'].'.index', [$lang, $value]);
        }else{
            $old_time_of_exp = User_Item::where('item_id', $item_id)->where('user_id' , $target_id)->pluck('time_of_exp');
            $time = $old_time_of_exp[0];
            $again = (new Carbon($time))->add($duration , 'day')->format('Y.m.d');
            $test = User_Item::where('item_id', $item_id)->where('user_id' , $target_id)->update(['time_of_exp' => $again ]);

            flashy(__('dashboard.created'));
            return redirect()->route($this->resource['route'].'.index', [$lang, $value]);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $value, $id)
    {
        App::setLocale($lang);
        $resource = $this->resource;
        $resource['action'] = 'Edit';
        $item = City::findOrFail($id);
        return view('dashboard.views.' .$this->resources. '.edit', compact('item', 'resource', 'value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $value, $id)
    {
        App::setLocale($lang);
        $rules =  [
            'name_ar' => 'required',
            'name_en' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }
        City::find($id)->update($request->all());

        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', [$lang, $value]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $value, $id)
    {
        App::setLocale($lang);
        $item = User_Item::findOrFail($id);
        $item->delete();
        return redirect()->route($this->resource['route'].'.index', [$lang, $value]);
    }

    public function multiDelete($lang, $value)
    {
        App::setLocale($lang);
        foreach (\request('checked') as $id)
        {
            $item = ProductImage::findOrFail($id);
            if (strpos($item->image, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->image);
                Storage::disk('public')->delete($image);
            }
            $item->delete();
        }

        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', [$lang, $value]);
    }

    public function search($lang, Request $request, $value)
    {
        App::setLocale($lang);
        $resource = $this->resource;
        $data = City::where('country_id', $value)
            ->where(function ($query) use ($request){
                $query->where('name_ar', 'LIKE', '%'.$request->text.'%')
                    ->orWhere('name_en', 'LIKE', '%'.$request->text.'%');
            })
            ->paginate(10);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource', 'value'));
    }

    public function ajax($lang){
        $item_id = Item::select("name", 'id')->where('cat_id', request('cat_id'))->get();
        return view('dashboard.views.' .$this->resources. '.sub', compact('item_id'))->render();
    }
}
