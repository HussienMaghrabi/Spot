<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use App\Models\UserBadge;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use App\Models\karizma_level;
use App\Models\Vip_tiers;
use App\Models\Badge;


class levelController extends Controller
{
    // ----> to do for adding exp in either level.(charisma/user level)
    // check for levels passed after his current leve(not only next level for him)
    // send level reached & category id 3 / 9 for user / charisma levels.
    // check first for daily limit for user.
    // handle exp rate for vip users.
    public function addUserExp($userExp, $user_id){
        $auth = $user_id;
        $cat = 3;
        $data = User::where('id', $auth)->select('curr_exp', 'user_level')->first();
        $nextLevel = $data->user_level + 1;
        $currExp = $data->curr_exp;
        $expReq = Level::where('id', $nextLevel)->pluck('points')[0];
        if ($this->vipLevel()) {
            if($this->vipLevel($this->vipLevel()['exp'] == 1))
            {
                $userExp = $userExp + ($userExp * $this->vipLevel()['exp_value'] /100) ;
            }
        }
        $added_exp = $currExp + $userExp;
        $exp_update = $added_exp - $expReq;
        if($added_exp > $expReq){
            $query = User::where('id', $auth)->update(['curr_exp' => $exp_update, 'user_level' => $nextLevel]);
            $this->badgesForLevelingUp($cat, $nextLevel);
        }
        else{
            $query = User::where('id', $auth)->update(['curr_exp' => $added_exp]);
        }
    }

    public function addUserKaizma($userExp, $user_id){
        $auth = $user_id;
        $cat = 9;
        $data = User::where('id',$auth)->select('karizma_exp', 'karizma_level')->first();
        $nextLevel = $data->karizma_level + 1;
        $expReq = karizma_level::where('id', $nextLevel)->pluck('points')[0];
        $currExp = $data->karizma_exp;
        if ($this->vipLevel()) {
            if($this->vipLevel($this->vipLevel()['exp'] == 1))
            {
                $userExp = $userExp + ($userExp * $this->vipLevel()['exp_value'] /100) ;
            }else{
                $userExp = $userExp;
            }
        }
        $addedExp = $currExp + $userExp;
        $exp_update = $addedExp - $expReq;
        if($addedExp > $expReq){
            $query = User::where('id', $auth)->update(['karizma_exp' => $exp_update, 'karizma_level' => $nextLevel]);
            $this->badgesForLevelingUp($cat, $nextLevel);
        }else{
            $query = User::where('id', $auth)->update(['karizma_exp' => $addedExp]);
        }
    }

    // cat is category for badges(parent_id), nextLevel is level reached by user.
    public function badgesForLevelingUp($cat, $nextLevel){
        $auth =  $this->auth();
        $data = Badge::where('category_id',$cat)->get();
        $badge_id = -1 ;
        foreach ($data as $item){
            if($nextLevel >= $item->amount){
                $badge_id =$item->id;
            }else{
                break;
            }
        }
        if ($badge_id != -1){
            $var = UserBadge::where('user_id',$auth)->where('badge_id', $badge_id)->first();
            if (!$var){
                $input['user_id'] = $auth;
                $input['badge_id'] = $badge_id ;
                UserBadge::create($input);
            }
        }
    }

    public function vipLevel()
    {
        // check if user has vip role
        if(!empty($this->user()['vip_role'])){
            $vip_tir = Vip_tiers::where('id',$this->user()['vip_role'])->first();
            return $vip_tir->privileges;
        }else{
            return false;
        }
    }

}
