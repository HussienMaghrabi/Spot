<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function search(Request $request)
    {
        $resource = $this->resource;
        $data = Item::select('items.name', 'items.price', 'items.duration', 'items.cat_id')
        ->join('item_categories', 'item_categories.id', '=', 'items.cat_id')
        ->Where('item_categories.name_ar', 'LIKE', '%'.$request->text.'%')
        ->orWhere('item_categories.name_en', 'LIKE', '%'.$request->text.'%')
        ->orwhere('items.name', 'LIKE', '%'.$request->text.'%')
        ->orWhere('items.price', 'LIKE', '%'.$request->text.'%')
        ->paginate(10);

        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }



}
