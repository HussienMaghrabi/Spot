<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;

class NotificationController extends Controller
{
    private $resources = 'notifications';
    private $resource = [
        'route' => 'admin.notifications',
        'view' => "notifications",
        'icon' => "rss",
        'title' => "Notifications",
        'action' => "",
        'header' => "Notifications"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resource = $this->resource;
        return view('dashboard.views.' .$this->resources. '.create', compact('resource'));
    }

    public function store(Request $request, $lang)
    {
        \Illuminate\Support\Facades\App::setLocale($lang);
        $title = $request->title;
        $body = $request->body;
        $topic =  '/topics/allDevices';



        $this->broadCastNotification($title,$body,$topic);

        $flash_message['ar'] = 'تم ارسال الاشعار';
        $flash_message['en'] = 'Notification has been sent';
        flashy($flash_message[$lang]);
        return back();

    }




}
