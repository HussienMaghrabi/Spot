<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Badge;
use App\Models\ban;
use App\Models\Item;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $resource = [
        'route' => 'admin.home',
        'icon' => "home",
        'title' => "DASHBOARD",
        'action' => "",
        'header' => "home"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics = [
            'admins'            => Admin::count(),
            'users'             => User::whereNull('vip_role')->count(),
            'vip_users'         => User::whereNotNull('vip_role')->count(),
            'bans'              => ban::where('status' , 'banned')->count(),
            'suspends'          => ban::where('status' , 'suspended')->count(),
            'badges'            => Badge::where('hidden' , 1)->count(),
            'rooms'             => Room::count(),
            'items'             => Item::count(),

        ];
        $resource = $this->resource;

        return view('dashboard.home', compact('statistics', 'resource'));
    }
}
