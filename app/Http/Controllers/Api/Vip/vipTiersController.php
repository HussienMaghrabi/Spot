<?php

namespace App\Http\Controllers\Api\Vip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vip_tiers;

class vipTiersController extends Controller
{
    public function getTirs(Request $request)
    {
        $vip_tirs = Vip_tiers::all();
        return $this->successResponse($vip_tirs);
    }
    public function getTir(Request $request)
    {
        $vip_tir = Vip_tiers::find($request->vip_id);
        if($vip_tir)
        {
            return $this->successResponse($vip_tir);
        }else{
            return $this->errorResponse($vip_tir);
        }
    }
}
