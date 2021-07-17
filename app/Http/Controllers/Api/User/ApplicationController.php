<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function aboutApp(){
        $lang = $this->lang();
        $about = "";
        if($lang == "ar"){
            $about = "عن التطبيق";
        }elseif($lang == "en"){
            $about = "about us";
        }
        return $this->successResponse($about, []);
    }
}
