<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;
use App\Models\Token;

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
}
