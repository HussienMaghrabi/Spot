<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        # ------------------------Base64-------------------------
        public function uploadBase64($base64, $path, $extension = 'jpeg')
        {
            $fileBaseContent = base64_decode($base64);
            $fileName = Str::random(10).'_'.time().'.'.$extension;
            $file = $path.'/'.$fileName;
            Storage::disk('public')->put('uploads/'.$file, $fileBaseContent);
            return 'uploads/' . $file;
        }

        public function uploadFile($file, $path)
        {
            $filename = Storage::disk('public')->put('uploads/'.$path, $file);
            return $filename;
        }

        # --------------------successResponse------------------
        public function successResponse($data, $message = NULL)
        {
            $response = array(
                'status'  => TRUE,
                'message' => $message,
                'data'    => $data
            );
            return response()->json($response, 200);
        }

        #------------------ format error----------------
        public function formatErrors($errors)
        {
            $stringError = "";
            for ($i=0; $i < count($errors->all()); $i++) {
                $stringError = $stringError . $errors->all()[$i];
                if($i != count($errors->all())-1){
                    $stringError = $stringError . '\n';
                }
            }
            return $stringError;
        }

        # --------------------errorResponse------------------
        public function errorResponse($errors , $data = NULL)
        {
            $response = array(
                'status'  => FALSE,
                'message' => $errors,
                'data'    => $data
            );
            return response()->json($response);
        }

        #------------------ lang ----------------
        public function lang()
        {
            App::setLocale(request()->header('lang'));
            if (request()->header('lang'))
            {
                return request()->header('lang');
            }
            return 'ar';
        }

        #------------------ Auth ----------------
        public function auth()
        {
            if (request()->header('Authorization'))
            {
                $user = User::where('api_token', request()->header('Authorization'))->first();

                if ($user)
                {
                    return $user->id;
                }

            }
            return 0;
        }

        #------------------ authAdmin ----------------
        public function authAdmin()
        {
            if (request()->header('Authorization'))
            {
                $admin = Admin::where('api_token', request()->header('Authorization'))->first();

                if ($admin)
                {
                    return $admin->id;
                }

            }
            return 0;
        }

    public function user()
    {
        if (request()->header('Authorization'))
        {
            $user = User::where('api_token', request()->header('Authorization'))->first();

            if ($user)
            {
                return $user;
            }

        }
        return 0;
    }
    public function userObj($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if ($user)
        {
            return $user;
        }
        else{
            return 0;
        }
    }

    # -------------------------------------------------
    public function broadCastNotification($title, $body, $topic,$id = null)
    {
        $auth_key = "AAAAC8KAag8:APA91bEsF5v1TbK2iipvYCkeyLkWDduNGYPlg9ZuGlow1V8MphMnr-liGfjZCD5EZRXoxxyQfFfcS2tVl186yBAKecvbyuJX59y0Wpp7CX_2NiE9O3tWZ9eor8vZ0seD6-iuylHSJgsu";
        $data = [
            'body'              => $body,
            'title'             => $title,
            'id'                => $id,
            'click_action'      => 'com.room_app',
            'icon'              => 'myicon',
            'banner'            => '1',
            'sound'             => 'mySound',
            "priority"          => "high",
        ];

        $notification = [
            'body'              => $body,
            'title'             => $title,
            'id'                => $id,
            'click_action'      => 'com.room_app',
            'data'              => $data,
            'icon'              => 'myicon',
            'banner'            => '1',
            'sound'             => 'mySound',
            "priority"          => "high",
        ];

        $fields = json_encode([
            'to'                => $topic,
            'notification'      => $notification,
            'data'              => $data,
        ]);

        $ch = curl_init ();

        curl_setopt ( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec ( $ch );
        curl_close ( $ch );



    }

    # -------------------------------------------------
    public function pushNotification($notification)
    {
        $auth_key = "AAAAC8KAag8:APA91bEsF5v1TbK2iipvYCkeyLkWDduNGYPlg9ZuGlow1V8MphMnr-liGfjZCD5EZRXoxxyQfFfcS2tVl186yBAKecvbyuJX59y0Wpp7CX_2NiE9O3tWZ9eor8vZ0seD6-iuylHSJgsu";

        $device_token = $notification['fcm_token'];
//        if($device_token == NULL){
//            return 0;
//        }

        $data = [
            'body' 	            => $notification['body'],
            'title'	            => $notification['title'],
            'id'	            => $notification['id'],
            'click_action'      => 'com.room_app',
            'icon'	            => 'myicon',
            'banner'            => '1',
            'sound'             => 'mySound',
            "priority"          => "high",
        ];

        $notification = [
            'body' 	            => $notification['body'],
            'title'	            => $notification['title'],
            'id'	            => $notification['id'],
            'click_action'      => 'com.room_app',
            'data'              => $data,
            'icon'	            => 'myicon',
            'banner'            => '1',
            'sound'             => 'mySound',
            "priority"          => "high",
        ];

        $fields = json_encode([
            'registration_ids'  => $device_token,
            'notification'      => $notification,
            'data'              => $data,
        ]);

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec ( $ch );
        curl_close ( $ch );

    }
}
