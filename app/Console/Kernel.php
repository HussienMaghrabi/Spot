<?php

namespace App\Console;

use App\Http\Controllers\Api\Leaders\topController;

use App\Models\Recharge_top_daily;
use App\Models\Recharge_top_weekly;
use App\Models\Recharge_transaction;
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
        $schedule->call(function () {
            $now = Carbon::now()->format('Y-m-d');
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
