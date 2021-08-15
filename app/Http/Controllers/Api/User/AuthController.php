<?php

namespace App\Http\Controllers\Api\User;

use App\Models\ban;
use App\Models\Coins_purchased;
use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\login_check;
use App\Models\UserBadge;
use App\Models\Badge;
use DB;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        $rules =[
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {
            log::debug('error message '.$errors);
            return $this->errorResponse($errors);
        }

        $user_id = User::where('email',request('email'))->pluck('id')->first();
        $var = ban::where('user_id',$user_id)->first();
        if(!$var){
            $check = User::where('email',request('email'))->pluck('verify')->first();
            if($check == 1){

                $user = auth()->attempt(["email" => $request["email"] ,"password" => $request["password"] ]);
                if (!$user){
                    log::debug('error message '.__('api.LoginFail'));
                    return $this->errorResponse(__('api.LoginFail'),[]);
                }
                log::debug('success message '.$request);
                return $this->response($request);
            }else{
                log::debug('error message '.__('api.notVerify'));
                return $this->errorResponse(__('api.notVerify'),[]);
            }
        }else{
            if ($var->status == 'banned'){
                $message = __('api.banned');
                log::debug('error message '.$message);
                return $this->errorResponse($message);
            }else{
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
        }
    }

    public function response(Request $request)
    {
        $item = new UserResource(auth()->user());
        return $this->successResponse($item, __('api.LoginSuccess'));
    }

    public function register(Request $request)
    {
        // debug request
        log::debug('register api called');
        $req = request()->all();
        foreach ($req as $re){
            log::debug('request object contains :'.$re);
        }

        //$rules && $validator
        $rules =  [
            'email'  => 'required|unique:users',
            'password'  => 'required',

        ];
        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {
            log::debug('error message '.$errors);
            return $this->errorResponse($errors);
        }

        // Check image & token
        $input = request()->except('profile_pic','api_token');
        $token = Str::random(70);
        $special_id = Int::random(9);
        $input['api_token'] = $token;
        $input['special_id'] = $special_id;
        $input['code'] = rand(1111, 9999);
        $input['verify'] = 0;

        // create new user & send email to Confirm Code
        $user =User::create($input);
        Mail::to($user)->send(new SendMail($user));
        log::debug('success message '. __('api.checkMail'));
        return $this->successResponse(null, __('api.checkMail'));
    }

    public function confirmCode(Request $request)
    {
        log::debug('confirmCode api called');

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
            log::debug('success message '. $user);
            return $this->responseUser($request);

        } else{
            log::debug('error message '.__('api.PromoFail'));
            return $this->errorResponse(__('api.PromoFail'));
        }
    }

    public function responseUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $item = new UserResource($user);
        return $this->successResponse($item, __('api.LoginSuccess'));
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
        $newUserCoins = 0;
        if($checkLogin->last_login_day != date('Y-m-d'))
        {
            $data['days_count'] = $checkLogin->days_count +  1;
            $data['last_login_day'] = Carbon::now();
            DB::table('login_check')->where('user_id',$userId)->update($data);
            // check on users days

            // to do -> add new badges to user instead of updating them.
            $badges = Badge::where('category_id',7)->get();
            foreach ($badges as $key => $bagde) {
                if ($bagde->amount <= $data['days_count']){
                    $userbadges = UserBadge::where('user_id',$userId)->where('badge_id',$bagde->id)->first();
                    if (!$userbadges) {
                        DB::table('user_badges')->insert(['user_id'=>$userId,'badge_id'=>$bagde->id]);
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
                $newUserCoins += $insCoins;
            }
            $insCoins = $oldCoins + $gift_check->coins;
            $userPriv = $userObj->vip['privileges'];
            $check = $userPriv['daily_login_reward'];
            $coins = 0 ;
            if($check == 1){
                $coins = $userPriv['daily_login_reward_value'];
                $oldCoins = $userObj->coins;
                $newCoins = $coins + $oldCoins;
                $userObj->update(['coins'=>$newCoins]);
                $newUserCoins += $coins;
            }

            $var['status'] = 'daily_login';
            $var['amount'] = $coins + $gift_check->coins;
            $var['date_of_purchase'] = date('Y-m-d');
            $var['user_id'] = $userId;
            Coins_purchased::create($var);
            $gift_check['newUserCoins'] = $newUserCoins;
            $gift_check['$coins'] = $coins;
            $gift_check['$insCoins'] = $insCoins;
            $message = __('api.success');
            return $this->successResponse($gift_check,$message);
        }
        else{
            return $this->errorResponse(" ",[]);
        }

    }

    protected function lastDay()
    {
        $previousDay = Carbon::now()->subDays(1);
        log::debug($previousDay);
        return $previousDay;
    }

    public function searchBySpecialId(Request $request){
        $target_user = User::where('special_id', $request->input('special_id'))->first();
        if($target_user === null){
            $message = __('api.userNotFound');
            return $this->errorResponse($message,[]);
        }else{
            $user = new UserResource($target_user);
            return $this->successResponse($user, __('api.success'));
        }

    }

    public function getCoins(){
        $auth = $this->auth();
        $user = User::where('id', $auth)->first();
        if($user){
            $message = __('api.success');
            return $this->successResponse($user->coins, $message);
        }
        else{
            $message = __('api.noUser');
            return $this->errorResponse($message, []);
        }
    }
}
