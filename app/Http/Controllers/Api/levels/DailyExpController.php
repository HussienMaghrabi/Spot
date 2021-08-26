<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use App\Models\UserDailyLimitExp;
use Illuminate\Http\Request;

class DailyExpController extends Controller
{
    public function checkMicExp(Request $request){
        $auth = $this->auth();
        $addedAmount = $request->input('mic_exp_add');
        $user_limit = UserDailyLimitExp::where('user_id', $auth)->select('mic_exp', 'updated_at')->get();

    }
}
