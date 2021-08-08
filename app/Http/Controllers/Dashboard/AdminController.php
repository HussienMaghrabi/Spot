<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $resources = 'admins';
    private $resource = [
        'route' => 'admin.admins',
        'view' => "admins",
        'icon' => "user-secret",
        'title' => "ADMINS",
        'action' => "",
        'header' => "Admins"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Admin::orderBy('id', 'DESC')->paginate(10);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource'));
    }
}
