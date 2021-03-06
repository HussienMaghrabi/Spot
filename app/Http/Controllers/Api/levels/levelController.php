<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User_Item;
use App\Models\UserBadge;
use Carbon\Carbon;
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
        $data = User::where('id', $auth)->select('curr_exp', 'user_level', 'coins')->first();
        $nextLevel = $data->user_level + 1;
        $currExp = $data->curr_exp;
        $coinsReq = Level::where('id', $nextLevel)->pluck('coins')[0];
        if ($coinsReq != null){
            $nextCoins = $data->coins + $coinsReq;
        }else{
            $nextCoins = $data->coins;
        }
        $expReq = Level::where('id', $nextLevel)->pluck('points')[0];
        if ($this->vipLevel($auth)) {
            if($this->vipLevel($auth)['exp'] == 1)
            {
                $userExp = $userExp * $this->vipLevel($auth)['exp_value'];
            }
        }
        $added_exp = $currExp + $userExp;
        $exp_update = $added_exp - $expReq;
        if($added_exp > $expReq){
            $query = User::where('id', $auth)->update(['curr_exp' => $exp_update, 'user_level' => $nextLevel, 'coins'=>$nextCoins]);
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
        $itemReq = karizma_level::where('id', $nextLevel)->pluck('item_id')[0];
        $duration = -1;
        if($itemReq){
            $duration = Item::where('id',$itemReq)->pluck('duration')[0];
        }
        $currExp = $data->karizma_exp;
        if ($this->vipLevel($auth)) {
            if($this->vipLevel($auth)['exp'] == 1)
            {
                $userExp =  $userExp * $this->vipLevel($auth)['exp_value']  ;
            }else{
                $userExp = $userExp;
            }
        }
        $addedExp = $currExp + $userExp;
        $exp_update = $addedExp - $expReq;
        if($addedExp > $expReq){
            $query = User::where('id', $auth)->update(['karizma_exp' => $exp_update, 'karizma_level' => $nextLevel]);
            if($itemReq){
                $user_item = User_Item::where('user_id',$auth)->where('item_id',$itemReq)->get();
                if ($user_item == null){
                    User_Item::create([
                        'user_id'=>$auth,
                        'item_id'=>$itemReq,
                        'time_of_exp'=>$duration
                    ]);
                }else{
                    $carbonObj = Carbon::now()->createFromDate($user_item->time_of_exp)->addDays($duration);
                    $user_item->update([
                        'time_of_exp'=> $carbonObj
                    ]);
                }
            }


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

    public function vipLevel($user_id)
    {
        // check if user has vip role
        $vip = $this->userObj($user_id)['vip_role'];
        if($vip == null){
            return false;
        }else{
            $vip_tir = Vip_tiers::where('id',$vip)->first();
            return $vip_tir->privileges;
        }
    }

}
