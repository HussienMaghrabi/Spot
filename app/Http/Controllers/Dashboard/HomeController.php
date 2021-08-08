<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
            'users'             => User::count(),

        ];
        $resource = $this->resource;

        return view('dashboard.home', compact('statistics', 'resource'));
    }
}
