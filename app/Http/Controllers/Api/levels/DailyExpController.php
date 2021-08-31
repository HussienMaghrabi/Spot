<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use App\Models\DailyLimitExp;
use App\Models\UserDailyLimitExp;
use Carbon\Carbon;

// return the added exp according to the current exp for the user and max limit he can get
class DailyExpController extends Controller
{
    // takes active minutes on mic and returns the added exp for the user
    public function checkMicExp($time){
        $auth = $this->auth();
        $minutes = $time;
        $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('mic_exp', 'last_day')->first();
        if( $user_limit ===  null){
            UserDailyLimitExp::create(['user_id' => $auth]);
            $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('mic_exp', 'updated_at')->first();
        }
        $max_exp = DailyLimitExp::all();
        $max_limit = $max_exp[0]->mic_exp_max;
        $added_exp = $minutes * $max_exp[0]->mic_exp_val;
        $now = Carbon::now()->format('Y-m-d');
        // last exp was yesterday
        if( $now > $user_limit->last_day ){
            $final_exp = $added_exp;
            UserDailyLimitExp::where('user_id', $auth)->update(['mic_exp'=>$final_exp, 'last_day'=>$now]);
            return $added_exp;
        }
        // still can take exp today
        elseif( ($user_limit->mic_exp < $max_limit) && ($now == $user_limit->last_day) ) {
            // total less than max limit
            if(($user_limit->mic_exp + $added_exp) <= $max_limit){
                $final_exp = $user_limit->mic_exp + $added_exp;
                UserDailyLimitExp::where('user_id', $auth)->update(['mic_exp'=>$final_exp, 'last_day'=>$now]);
                return $added_exp;
            }
            // total is more than max limit
            else{
                $final_exp = $max_limit - $user_limit->mic_exp;
                UserDailyLimitExp::where('user_id', $auth)->update(['mic_exp'=>$max_limit, 'last_day'=>$now]);
                return $final_exp;
            }
        }
        // cannot take more exp
        else{
            return 0;
        }
    }
    // return the added exp for the user for following another user
    public function checkFollowExp(){
        $auth = $this->auth();
        $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('follow_exp', 'last_day')->first();
        if( $user_limit ===  null){
            UserDailyLimitExp::create(['user_id' => $auth ]);
            $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('follow_exp', 'last_day')->first();
        }
        $max_exp = DailyLimitExp::all();
        $max_limit = $max_exp[0]->follow_exp_max;
        $added_exp = 1 * $max_exp[0]->follow_exp_val;
        $now = Carbon::now()->format('Y-m-d');
        // last exp was yesterday
        if( $now > $user_limit->last_day ){
            $final_exp = $added_exp;
            UserDailyLimitExp::where('user_id', $auth)->update(['follow_exp'=>$final_exp, 'last_day'=>$now]);
            return $added_exp;
        }
        // still can take exp today
        elseif( ($user_limit->follow_exp < $max_limit) && ($now == $user_limit->last_day) ) {
            // total less than max limit
            if(($user_limit->follow_exp + $added_exp) <= $max_limit){
                $final_exp = $user_limit->follow_exp + $added_exp;
                UserDailyLimitExp::where('user_id', $auth)->update(['follow_exp'=>$final_exp, 'last_day'=>$now]);
                return $added_exp;
            }
            // total is more than max limit
            else{
                $final_exp = $max_limit - $user_limit->follow_exp;
                UserDailyLimitExp::where('user_id', $auth)->update(['follow_exp'=>$max_limit, 'last_day'=>$now]);
                return $final_exp;
            }
        }
        // cannot take more exp
        else{
            return 0;
        }

    }
    // takes number of gifts sent and returns the added exp for the user
    public function checkSendGiftExp($count){
        $auth = $this->auth();
        $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('gift_send', 'last_day')->first();
        if( $user_limit ===  null){
            UserDailyLimitExp::create(['user_id' => $auth ]);
            $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('gift_send', 'last_day')->first();
        }
        $max_exp = DailyLimitExp::all();
        $max_limit = $max_exp[0]->gift_send_max;
        $added_exp = $count * 1;
        $now = Carbon::now()->format('Y-m-d');
        // last exp was yesterday
        if( $now > $user_limit->last_day ){
            $final_exp = $added_exp;
            UserDailyLimitExp::where('user_id', $auth)->update(['gift_send'=>$final_exp, 'last_day'=>$now]);
            return $added_exp;
        }
        // still can take exp today
        elseif( ($user_limit->gift_send < $max_limit) && ($now == $user_limit->last_day) ) {
            // total less than max limit
            if(($user_limit->gift_send + $added_exp) <= $max_limit){
                $final_exp = $user_limit->gift_send + $added_exp;
                UserDailyLimitExp::where('user_id', $auth)->update(['gift_send'=>$final_exp, 'last_day'=>$now]);
                return $added_exp;
            }
            // total is more than max limit
            else{
                $final_exp = $max_limit - $user_limit->gift_send;
                UserDailyLimitExp::where('user_id', $auth)->update(['gift_send'=>$max_limit, 'last_day'=>$now]);
                return $final_exp;
            }
        }
        // cannot take more exp
        else{
            return 0;
        }
    }
    // takes number of gifts received and returns the added exp for the user
    public function checkReceiveGiftExp($count, $user_id){
        $auth = $user_id;
        $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('gift_receive', 'last_day')->first();
        if( $user_limit ===  null){
            UserDailyLimitExp::create(['user_id' => $auth ]);
            $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('gift_receive', 'last_day')->first();
        }
        $max_exp = DailyLimitExp::all();
        $max_limit = $max_exp[0]->gift_receive_max;
        $added_exp = $count * 1;
        $now = Carbon::now()->format('Y-m-d');
        // last exp was yesterday
        if( $now > $user_limit->last_day ){
            $final_exp = $added_exp;
            UserDailyLimitExp::where('user_id', $auth)->update(['gift_receive'=>$final_exp, 'last_day'=>$now]);
            return $added_exp;
        }
        // still can take exp today
        elseif( ($user_limit->gift_receive < $max_limit) && ($now == $user_limit->last_day) ) {
            // total less than max limit
            if(($user_limit->gift_receive + $added_exp) <= $max_limit){
                $final_exp = $user_limit->gift_receive + $added_exp;
                UserDailyLimitExp::where('user_id', $auth)->update(['gift_receive'=>$final_exp, 'last_day'=>$now]);
                return $added_exp;
            }
            // total is more than max limit
            else{
                $final_exp = $max_limit - $user_limit->gift_receive;
                UserDailyLimitExp::where('user_id', $auth)->update(['gift_receive'=>$max_limit, 'last_day'=>$now]);
                return $final_exp;
            }
        }
        // cannot take more exp
        else{
            return 0;
        }
    }
    // takes charging amount and returns added exp for the user
    public function checkChargeExp($amount){
        $auth = $this->auth();
        $coins = $amount;
        $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('charge', 'last_day')->first();
        if( $user_limit ===  null){
            UserDailyLimitExp::create(['user_id' => $auth]);
            $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('charge', 'updated_at')->first();
        }
        $max_exp = DailyLimitExp::all();
        $added_exp = $coins * $max_exp[0]->charge_val;
        $now = Carbon::now()->format('Y-m-d');
        // last exp was yesterday -> reset exp
        if( $now > $user_limit->last_day ){
            $final_exp = $added_exp;
            UserDailyLimitExp::where('user_id', $auth)->update(['mic_exp'=>$final_exp, 'last_day'=>$now]);
            return $added_exp;
        }
        // last exp is today -> add exp
        elseif($now == $user_limit->last_day){
            $final_exp = $user_limit->mic_exp + $added_exp;
            UserDailyLimitExp::where('user_id', $auth)->update(['mic_exp'=>$final_exp, 'last_day'=>$now]);
            return $added_exp;
        }
    }

    // returns added exp for the user for daily login-in
    public function checkDailyLoginExp(){
    $someWorkShouldBeDone = true;
    }
    // takes amount of coins for sent gifts and returns the added exp for the user
    public function checkCoinsSendGiftsExp($total){

    }
}
