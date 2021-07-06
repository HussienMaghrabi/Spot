<?php

namespace App\Http\Controllers\Api\User;

use App\Models\ban;
use App\Models\country;
use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\daily_gift;
use App\Models\login_check;
use App\Models\UserBadge;
use App\Models\Badge;
use DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        log::debug('login api called');
        $req = request()->all();
        foreach ($req as $re){
            log::debug('request object contains :'.$re);
        }
        $this->lang();
        $rules =  [
            'email'    => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            log::debug('error message '.$validator->errors()->all()[0]);
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $user_id = User::where('email',request('email'))->pluck('id')->first();
        $var = ban::where('user_id',$user_id)->first();
        if($var){
            if ($var->status == 'banned'){
                $message = __('api.banned');
                log::debug('error message '.$message);
                return $this->errorResponse($message);
            }else{
                $now = Carbon::now();
                $created_at = date('Y-m-d',strtotime($var->created_at));
                $dateEnd = Carbon::now()->subDays($var->num_of_days +1);
                $length = $dateEnd->diffInDays($created_at );
                if($length > 1){
                    $message = __('api.suspended '. $length). __('api.days');
                }else{
                    $message = __('api.suspended '. $length). __('api.day');
                }
                log::debug('error message '.$message);
                return $this->errorResponse($message);
            }
        }else{
            $check = User::where('email',request('email'))->pluck('verify')->first();
            if($check == 1){
                if (Auth::guard('apiUser')->attempt(['email' => request('email'), 'password' => request('password')]))
                {
                    $auth = Auth::guard('apiUser')->user();
                    $token = Str::random(70);
                    User::where('id',$auth->id)->update(['api_token'=>$token]);
                    $data =User::where('id',$auth->id)->select(
                    'id',
                    'name',
                    'email',
                    'profile_pic as image',
                    'curr_exp',
                    'coins',
                    'gems',
                    'birth_date',
                    'desc',
                    'user_level',
                    'gender',
                    'country_id',
                    'karizma_exp',
                    'karizma_level',
                    'created_at',
                    'completed',
                    'api_token',
                )->first();
                    $data->images= [];

                    $data->country_name = $data->country['name'];
                    unset($data->country);
                    // self::DailyLoginCheck($auth->id);
                    log::debug('success message '.$data);
                    return $this->successResponse($data,  __('api.RegisterSuccess'));
                }
                log::debug('error message '.__('api.LoginFail'));
                return $this->errorResponse(__('api.LoginFail'),[]);
            }else{
                log::debug('error message '.__('api.notVerify'));
                return $this->errorResponse(__('api.notVerify'),[]);
            }
        }
    }

    public function register(Request $request)
    {
        log::debug('register api called');
        $req = request()->all();
        foreach ($req as $re){
            log::debug('request object contains :'.$re);
        }
        $this->lang();
        $rules =  [
            'name'  => 'required',
            'email'  => 'required|unique:users',
            'password'  => 'required',
            'profile_pic'  => 'nullable',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {
            log::debug('error message '.$errors);
            return $this->errorResponse($errors);
        }

        $input = request()->except('profile_pic','api_token');


        if (request('profile_pic'))
        {
            $input['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users');
        }
        $token = Str::random(70);
        $input['api_token'] = $token;
        $input['code'] = rand(1111, 9999);
        $input['verify'] = 0;
        $user =User::create($input);

        Mail::to($user)->send(new SendMail($user));
        log::debug('success message '. __('api.checkMail'));
        return $this->successResponse(null, __('api.checkMail'));
    }

    public function confirmCode(Request $request)
    {
        log::debug('confirmCode api called');
        $req = request()->all();
        foreach ($req as $re){
            log::debug('request object contains :'.$re);
        }
        $rules =  [
            'email' => 'required',
            'code' => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {
            log::debug('error message '.$errors);
            return $this->errorResponse($errors);}

        $user = User::where('email', $request->email)->first();

        if($user === null){
            log::debug('error message '.__('api.EmailNotFound'));
            return $this->errorResponse(__('api.EmailNotFound'));
        }
        if($user->code == $request->code){
            User::where('email',$request->email)->update(['verify'=>1, 'code' => null]);
            $data = $user::where('email',$request->email)->select(
                'id',
                'name',
                'email',
                'profile_pic as image',
                'curr_exp',
                'coins',
                'gems',
                'user_level',
                'gender',
                'country_id',
                'karizma_exp',
                'karizma_level',
                'created_at',
                'completed',
                'api_token',
            )->first();
            $data->images= [];
            $data->country_name = $data->country['name'];
            unset($data->country);
            log::debug('success message '. $data);
            return $this->successResponse($data, __('api.Activate'));
        } else{
            log::debug('error message '.__('api.PromoFail'));
            return $this->errorResponse(__('api.PromoFail'));
        }
    }

    public function social(){
        log::debug('social api called');
        $req = request()->all();
        foreach ($req as $re){
            log::debug('request object contains :'.$re);
        }
        $rules =  [
            'email'  => 'required',
        ];
        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {
            log::debug('error message '.$errors);
            return $this->errorResponse($errors);
        }

        $data = User::where('email',request('email'))->first();
        if ($data)
        {
            $auth = $data->id;
            $token = Str::random(70);
            User::where('id',$auth)->update(['api_token'=>$token]);
            $items = User::where('id', $auth)->select('api_token')->first();
            log::debug('success message '. $items);
            return $this->successResponse($items,  __('api.RegisterSuccess'));
        }
        log::debug('error message '.__('api.LoginFail'));
        return $this->errorResponse(__('api.LoginFail'),null);
    }

    public function logout()
    {
        log::debug('logout api called');
        $req = request()->header();
        foreach ($req as $re){
            log::debug('request object contains :'.$re);
        }
        $this->lang();
        $auth = $this->auth();
        User::Where('id',$auth)->update(['api_token' => null ]);
        log::debug('success message '.  __('api.Logout'));
        return $this->successResponse(null, __('api.Logout'));
    }

    public function DailyLoginCheck(Request $request){
        // check on table Daily login
        $userId = $this->auth();
        $data = [];
        $checkLogin = DB::table('login_check')->where('user_id',$userId)->first();
        // dd($checkLogin);
        if($checkLogin)
        {
            $data['last_login_day'] = Carbon::now();
            if($checkLogin->last_login_day <= date('Y-m-d', strtotime("-2 days")))
            {
                $data['last_daily_gift'] = 1;
                DB::table('login_check')->where('user_id',$userId)->update($data);
            }else{
                if($checkLogin->last_daily_gift == 7){
                    $data['last_daily_gift'] = 7;
                }
                else if($checkLogin->last_daily_gift != 7 && $checkLogin->last_login_day == date('Y-m-d')){
                    $data['last_daily_gift'] = $checkLogin->last_daily_gift;
                }else{
                    $data['last_daily_gift'] = $checkLogin->last_daily_gift + 1;
                }
                DB::table('login_check')->where('user_id',$userId)->update($data);
            }
        }else{
            // insert first row in database
            DB::beginTransaction();
            try{
                $data['user_id'] = $userId;
                $data['last_login_day'] = Carbon::now()->subDay();
                $data['last_daily_gift'] = 1;
                $data['days_count'] = 0;
                $ins = DB::table('login_check')->insert($data);

                DB::commit();
                $checkLogin = DB::table('login_check')->where('user_id',$userId)->first();
            }catch(\Exception $e){
                log::debug('error message '.$e);
                return $this->errorResponse($e);
                DB::rollback();
            }
        }
        if($checkLogin->last_login_day != date('Y-m-d'))
        {
            $data['days_count'] = $checkLogin->days_count +  1;
            $data['last_login_day'] = Carbon::now();
            DB::table('login_check')->where('user_id',$userId)->update($data);
            // check on users days
            $badges = Badge::where('category_id',4)->get();
            $userbadges = new UserBadge;
            $userbadges = $userbadges->where('user_id',$userId)->where('category_id',4)->first();
            foreach ($badges as $key => $bagde) {
                if ($bagde->amount == $data['days_count']){
                    if ($userbadges) {
                        DB::table('user_badges')->update(['user_id'=>$userId,'category_id'=>4,'badge_id'=>$bagde->id]);
                    }else{
                        DB::table('user_badges')->insert(['user_id'=>$userId,'category_id'=>4,'badge_id'=>$bagde->id]);
                    }
                }
            }

            $userObj = User::where('id', $userId)->first();
            $oldCoins = $userObj->coins;
            // store gift or items or coins
            // 1- get the daily gift recourde
            $gift_check = login_check::where('last_login_day',date('Y-m-d'))->where("user_id",$userId)->first()->daily_gift;
            $ins = [];
            if(!empty($gift_check->gift_id) && empty($gift_check->item_id) && empty($gift_check->coins))
            {
                // insert in user item
                $ins['receiver_id'] = $userId;
                $ins['gift_id'] = $gift_check->gift_id;
                $ins['date_sent'] = date('Y-m-d');
                DB::table("user_gifts")->insert($ins);
            }
            else if(!empty($gift_check->item_id) && empty($gift_check->gift_id) && empty($gift_check->coins))
            {
                $userItem = new \App\Models\User_Item;
                $ins['user_id'] = $userId;
                $ins['item_id'] = $gift_check->item_id;
                $ins['is_activated'] = 1;
                // get Exp date for item Id
                $item = DB::table('items')->select('id','price','type','duration')->where('id',$gift_check->item_id)->first();
                $ins['time_of_exp'] = Carbon::now()->add($item->duration, 'day');
                if($userItemObj = $userItem->where('user_id',$userId)->where('item_id',$gift_check->item_id)->first())
                {
                    $userItemObj->update(['time_of_exp' => Carbon::now()->add($item->duration, 'day')]);
                }else{
                    $userItem->create($ins);
                }
            }
            else if(empty($gift_check->item_id) && empty($gift_check->gift_id) && !empty($gift_check->coins))
            {
                $insCoins = $oldCoins + $gift_check->coins;
                $userObj->update(['coins' => $insCoins]);
            }
            $userPriv = $userObj->vip['privileges'];
            $check = $userPriv['daily_login'];
            if($check){
                $coins = $userPriv['daily_gift'];
                $oldCoins = $userObj->coins;
                $newCoins = $coins + $oldCoins;
                $userObj->update(['coins'=>$newCoins]);
            }
            log::debug('success message '.  $gift_check);
            return $this->successResponse($gift_check,'success response');
        }
        else{
            log::debug('error message '."already claimed today's gift");
            return $this->errorResponse("already claimed today's gift");
        }

    }

    protected function lastDay()
    {
        $previousDay = Carbon::now()->subDays(1);
        log::debug($previousDay);
        return $previousDay;
    }
}
