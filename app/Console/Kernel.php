<?php

namespace App\Console;

use App\Http\Controllers\Api\Leaders\topController;

use App\Models\Receiver_top_daily;
use App\Models\Receiver_top_monthly;
use App\Models\Receiver_top_weekly;
use App\Models\Recharge_top_daily;
use App\Models\Recharge_top_weekly;
use App\Models\Recharge_transaction;
use App\Models\Sender_top_daily;
use App\Models\Sender_top_monthly;
use App\Models\Sender_top_weekly;
use App\Models\User_gifts;
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
