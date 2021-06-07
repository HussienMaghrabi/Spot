<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\daily_gift;
use App\Models\login_check;
use DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        $this->lang();
        $rules =  [
            'email'    => 'required',
            'password' => 'required',
        ];


        $validator = Validator::make(request()->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $check = User::where('email',request('email'))->pluck('verify')->first();

        if($check == 1){
            if (Auth::guard('apiUser')->attempt(['email' => request('email'), 'password' => request('password')]))
            {
                $auth = Auth::guard('apiUser')->user();
                $token = Str::random(70);
                User::where('id',$auth->id)->update(['api_token'=>$token]);
                $data['api_token'] = $token;
                // self::DailyLoginCheck($auth->id);
                return $this->successResponse($data,  __('api.RegisterSuccess'));
            }
            return $this->errorResponse(__('api.LoginFail'),null);
        }else{
            return $this->errorResponse(__('api.notVerify'),null);
        }

    }

    public function register(Request $request)
    {
        $this->lang();
        $rules =  [
            'name'  => 'required',
            'email'  => 'required|unique:users',
            'password'  => 'required',
            'profile_pic'  => 'nullable',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

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

        return $this->successResponse(null, __('api.checkMail'));
    }

    public function confirmCode(Request $request)
    {
        $rules =  [
            'email' => 'required',
            'code' => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $user = User::where('email', $request->email)->first();

        if($user->code == $request->code){
            User::where('email',$request->email)->update(['verify'=>1, 'code' => null]);
            $data = $user::select('id', 'name', 'profile_pic', 'email','api_token')->first();
            return $this->successResponse($data, __('api.Activate'));
        } else{
            return $this->errorResponse(__('api.PromoFail'));
        }
    }

    public function social(){
        $rules =  [
            'email'  => 'required',
        ];
        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $data = User::where('email',request('email'))->first();
        if ($data)
        {
            $auth = $data->id;
            $token = Str::random(70);
            User::where('id',$auth)->update(['api_token'=>$token]);
            $items = User::where('id', $auth)->select('api_token')->first();


            return $this->successResponse($items,  __('api.RegisterSuccess'));
        }
        return $this->errorResponse(__('api.LoginFail'),null);
    }

    public function logout()
    {
        $this->lang();
        $auth = $this->auth();
        User::Where('id',$auth)->update(['api_token' => null ]);

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
                $data['last_login_day'] = Carbon::now();
                $data['last_daily_gift'] = 1;
                $data['days_count'] = 1;
                $ins = DB::table('login_check')->insert($data);
                DB::commit();
            }catch(\Exception $e){
                return $this->errorResponse($e);
                DB::rollback();
            }
        }
        if($checkLogin->last_login_day != date('Y-m-d'))
        {
            $data['days_count'] = $checkLogin->days_count +  1;
            DB::table('login_check')->where('user_id',$userId)->update($data);
        }
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
                // 
                $ins['time_of_exp'] = Carbon::now()->add($item->duration, 'day');
                if($userItemObj = $userItem->where('user_id',$userId)->where('item_id',$gift_check->item_id)->first())
                {
                    $userItemObj->update(['time_of_exp' => Carbon::now()->add($item->duration, 'day')]);
                }else{
                    $userItem->create($ins);
                }
            }
            return $this->successResponse($gift_check,'success response');
    }

    protected function lastDay()
    {
        $previousDay = Carbon::now()->subDays(1);
        return $previousDay;
    }
}
