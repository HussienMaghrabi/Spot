<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use App\Models\Vip_tiers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    private $resources = 'items';
    private $resource = [
        'route' => 'admin.items',
        'view' => "items",
        'icon' => "bookmark",
        'title' => "ITEMS",
        'action' => "",
        'header' => "Items"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Item::orderBy('id', 'DESC')->paginate(10);
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
        $categories = ItemCategory::pluck('name_'.App::getLocale(), 'id')->all();
        $vip = Vip_tiers::pluck('name','id')->all();
        return view('dashboard.views.'.$this->resources.'.create',compact( 'resource','categories','vip'));

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
            'img_link' => 'required',
            'price' => 'required',
            'cat_id' => 'required',
            'duration' => 'required',
            'vip_item' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $items = $request->all();
        Item::create($items);

        App::setLocale($lang);
        flashy(__('dashboard.created'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        $resource = $this->resource;
        $resource['action'] = 'Edit';
        $item = Item::findOrFail($id);
        $categories = ItemCategory::pluck('name_'.App::getLocale(), 'id')->all();
        return view('dashboard.views.' .$this->resources. '.edit', compact('item', 'resource', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        Item::findOrFail($id)->delete();

        App::setLocale($lang);
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }


    public function multiDelete($lang)
    {
        foreach (\request('checked') as $id)
        {
            Admin::findOrFail($id)->delete();
        }


        App::setLocale($lang);
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }



    public function search(Request $request, $lang)
    {
        $resource = $this->resource;
        $data = Item::select('items.id','items.name','items.img_link', 'items.price', 'items.duration', 'items.cat_id')
        ->join('item_categories', 'item_categories.id', '=', 'items.cat_id')
        ->Where('item_categories.name_ar', 'LIKE', '%'.$request->text.'%')
        ->orWhere('item_categories.name_en', 'LIKE', '%'.$request->text.'%')
        ->orwhere('items.name', 'LIKE', '%'.$request->text.'%')
        ->orWhere('items.price', 'LIKE', '%'.$request->text.'%')
        ->paginate(20);

        App::setLocale($lang);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }



}
