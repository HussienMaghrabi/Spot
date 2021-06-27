<?php

namespace App\Http\Controllers\Api\levels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use App\Models\karizma_level;
use App\Models\Vip_tiers;
use App\Models\Badge;


class levelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function addUserExp($userExp){
        // $this->badgesForLevelingUp(5,10);
        $auth = $this->auth();
        $cat = 5;
        // check if vip
        // dd($this->vipLevel());
        // 
        $data = User::where('id', $auth)->select('curr_exp', 'user_level')->first();
        $nextLevel = $data->user_level + 1;
        $currExp = $data->curr_exp;
        $expReq = Level::where('id', $nextLevel)->pluck('points')[0];
        if ($this->vipLevel()) {
            if($this->vipLevel($this->vipLevel()['exp'] == 1))
            {
                $userExp = $userExp + ($userExp * $this->vipLevel()['exp_value'] /100) ;
            }else{
                $userExp = $userExp;
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

    public function addUserKaizma($userExp){
        $auth = $this->auth();
        $cat = 5;
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

    public function badgesForLevelingUp($cat, $nextLevel){
        $auth =  $this->auth();
        $data = Badge::where('category_id',$cat)->get();
        foreach ($data as $item){
            $badge_id = -1 ;
            if($nextLevel >= $item->amount){
                $badge_id =$item->id;
            }else{
                break;
            }
        }
        if ($badge_id != -1){
            $var = UserBadge::where('user_id',$auth)->where('category_id', $cat)->first();
            if ($var){

                if($var->badge_id != $badge_id){
                    UserBadge::where('user_id',$auth)->where('category_id', $cat)->update(['badge_id'=>$badge_id]);
                }
            }else{
                $input['user_id'] = $auth;
                $input['badge_id'] = $badge_id ;
                $input['category_id'] = $cat ;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
