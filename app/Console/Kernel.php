<?php

namespace App\Console;

use App\Http\Controllers\Api\Leaders\topController;

use App\Models\ban;
use App\Models\Receiver_top_daily;
use App\Models\Receiver_top_monthly;
use App\Models\Receiver_top_weekly;
use App\Models\Recharge_top_daily;
use App\Models\Recharge_top_monthly;
use App\Models\Recharge_top_weekly;
use App\Models\Recharge_transaction;
use App\Models\Room_top_daily;
use App\Models\Room_top_monthly;
use App\Models\Room_top_weekly;
use App\Models\Sender_top_daily;
use App\Models\Sender_top_monthly;
use App\Models\Sender_top_weekly;
use App\Models\User;
use App\Models\User_gifts;
use App\Models\User_Item;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // recharge top board
        $schedule->call(function () {
            $now = Carbon::now()->subDay()->format('Y-m-d');
            $data['user'] = Recharge_transaction::where('recharge_transactions.created_at','>=', $now)->groupByRaw('user_id')->select( DB::raw('sum(amount) as total'), 'user_id')->orderByDesc('total')->get();
            DB::table('recharge_top_dailies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->user_id;
                $query = Recharge_top_daily::create($input);
            }
        })->daily();
        $schedule->call(function () {
            $now = Carbon::now()->subDays(7)->format('Y-m-d');
            $data['user'] = Recharge_transaction::where('recharge_transactions.created_at','>=', $now)->groupByRaw('user_id')->select( DB::raw('sum(amount) as total'), 'user_id')->orderByDesc('total')->get();
            DB::table('recharge_top_dailies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->user_id;
                $query = Recharge_top_weekly::create($input);
            }
        })->sundays();
        $schedule->call(function () {
            $now = Carbon::now()->subMonth()->format('Y-m-d');
            $data['user'] = Recharge_transaction::where('recharge_transactions.created_at','>=', $now)->groupByRaw('user_id')->select( DB::raw('sum(amount) as total'), 'user_id')->orderByDesc('total')->get();
            DB::table('recharge_top_dailies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->user_id;
                $query = Recharge_top_monthly::create($input);
            }
        })->monthly();

        // sender top board
        $schedule->call(function () {
            $now = Carbon::now()->subDay()->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->groupByRaw('sender_id')->select( DB::raw('sum(price_gift) as total'), 'sender_id')->orderByDesc('total')->get();
            DB::table('sender_top_dailies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->sender_id;
                $query = Sender_top_daily::create($input);
            }
        })->daily();
        $schedule->call(function () {
            $now = Carbon::now()->subDays(7)->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->groupByRaw('sender_id')->select( DB::raw('sum(price_gift) as total'), 'sender_id')->orderByDesc('total')->get();
            DB::table('sender_top_weeklies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->sender_id;
                $query = Sender_top_weekly::create($input);
            }
        })->sundays();
        $schedule->call(function () {
            $now = Carbon::now()->subMonth()->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->groupByRaw('sender_id')->select( DB::raw('sum(price_gift) as total'), 'sender_id')->orderByDesc('total')->get();
            DB::table('sender_top_monthlies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->sender_id;
                $query = Sender_top_monthly::create($input);
            }
        })->monthly();

        // receiver top board
        $schedule->call(function () {
            $now = Carbon::now()->subDay()->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->groupByRaw('receiver_id')->select( DB::raw('sum(price_gift) as total'), 'receiver_id')->orderByDesc('total')->get();
            DB::table('receiver_top_dailies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->receiver_id;
                $query = Receiver_top_daily::create($input);
            }
        })->daily();
        $schedule->call(function () {
            $now = Carbon::now()->subDays(7)->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->groupByRaw('receiver_id')->select( DB::raw('sum(price_gift) as total'), 'receiver_id')->orderByDesc('total')->get();
            DB::table('receiver_top_weeklies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->receiver_id;
                $query = Receiver_top_weekly::create($input);
            }
        })->sundays();
        $schedule->call(function () {
            $now = Carbon::now()->subMonth()->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->groupByRaw('receiver_id')->select( DB::raw('sum(price_gift) as total'), 'receiver_id')->orderByDesc('total')->get();
            DB::table('receiver_top_monthlies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['user_id'] = $user->receiver_id;
                $query = Receiver_top_monthly::create($input);
            }
        })->monthly();

        // rooms top board
        $schedule->call(function () {
            $now = Carbon::now()->subDay()->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->where('room_id', '!=', null)->groupByRaw('room_id')->select( DB::raw('sum(price_gift) as total'), 'room_id')->orderByDesc('total')->get();
            DB::table('room_top_dailies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['room_id'] = $user->room_id;
                $query = Room_top_daily::create($input);
            }
        })->daily();
        $schedule->call(function () {
            $now = Carbon::now()->subDays(7)->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->where('room_id', '!=', null)->groupByRaw('room_id')->select( DB::raw('sum(price_gift) as total'), 'room_id')->orderByDesc('total')->get();
            DB::table('room_top_weeklies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['room_id'] = $user->room_id;
                $query = Room_top_weekly::create($input);
            }
        })->sundays();
        $schedule->call(function () {
            $now = Carbon::now()->subMonth()->format('Y-m-d');
            $data['user'] = User_gifts::where('user_gifts.created_at','>=', $now)->where('room_id', '!=', null)->groupByRaw('room_id')->select( DB::raw('sum(price_gift) as total'), 'room_id')->orderByDesc('total')->get();
            DB::table('room_top_monthlies')->truncate();
            foreach ($data['user'] as $user){
                $input['total'] =$user->total;
                $input['room_id'] = $user->room_id;
                $query = Room_top_monthly::create($input);
            }
        })->monthly();

        // remove suspension from users
        $schedule->call(function () {
            $query['user'] = ban::where('status', 'suspended')->select('id' , 'num_of_days', 'created_at')->get();
            foreach ($query['user'] as $user){
                $var = date('Y-m-d', strtotime($user->created_at));
                $now = Carbon::now()->subDays($user->num_of_days)->format('Y-m-d');
                if($var < $now){
                    $sql = ban::where('id', $user->id)->delete();
                }
            }
        })->daily();

        // remove expired items
        $schedule->call(function () {
            $now = Carbon::now()->format('Y-m-d');
            $query['item'] = User_Item::select('id', 'time_of_exp')->get();
            foreach ($query['item'] as $user){
                $var = date('Y-m-d', strtotime($user->time_of_exp));
                if($var < $now){
                    $sql = User_Item::where('id', $user->id)->delete();
                }
            }
        })->daily();

        // renew or remove vip tiers subscription
        $schedule->call(function () {
            $data['user'] = User::where('vip_role', '!=', null)->get();
            $now = Carbon::now();
            foreach ($data['user'] as $user){
                $next = Carbon::createFromDate($user->date_vip)->addMonth();
                $diff = $now->diffInDays($next);
                if($now > $next){
                    $user->update(['vip_role' => null, 'date_vip' => null]);
                }
            }
        })->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
