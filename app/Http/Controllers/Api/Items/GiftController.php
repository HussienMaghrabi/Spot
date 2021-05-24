<?php

namespace App\Http\Controllers\Api\Items;

use App\Models\Gift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class GiftController extends Controller
{

    public function showGifts()
    {
        $lang = $this->lang();
        $auth = 1;
        $data = Gift::where('reciever', $auth)->get();

        return $this->successResponse($data);
    }
}
