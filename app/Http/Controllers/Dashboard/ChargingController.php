<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Coins_purchased;
use App\Models\Recharge_transaction;
use App\Models\UserDiamondTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ChargingController extends Controller
{
    private $resources = 'recharge';
    private $resource = [
        'route' => 'admin.recharge',
        'view' => "recharge",
        'icon' => "university",
        'title' => "RECHARGE",
        'action' => "",
        'header' => "Recharge",
    ];

    public function index()
    {
        $now = Carbon::now()->subMonth()->format('Y-m-d');
        $data = Recharge_transaction::where('recharge_transactions.created_at','>=', $now)->select( DB::raw('sum(amount) as total'))->orderByDesc('total')->get();
        $data->map(function ($item){
            $item->khra = $item->select( DB::raw('sum(amount)as total'))->get();
            $item->all = $item->khra[0]->total;

            unset($item->khra);
        });
        $resource = $this->resource;

        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource'));
    }

    public function coins_history(Request $request,$lang,$id)
    {
        App::setLocale($lang);
        $target_user = $id;
        $now = Carbon::now()->subMonth()->format('Y-m-d');
        $data = Coins_purchased::where('user_id',$target_user)->where('created_at','>=', $now)->select('status','amount','date_of_purchase')->get();
        return view('dashboard.views.users.coins',compact('data'));
    }

    public function diamond_history(Request $request,$lang,$id)
    {
        App::setLocale($lang);
        $target_user = $id;
        $now = Carbon::now()->subMonth()->format('Y-m-d');
        $data = UserDiamondTransaction::where('user_id',$target_user)->where('created_at','>=', $now)->select('status','amount','created_at')->get();
        $data->map(function ($item){
            $item->date_of_purchase = $item->created_at->format('Y-m-d');
            unset($item->created_at);
        });

        return view('dashboard.views.users.diamond',compact('data'));
    }
}

