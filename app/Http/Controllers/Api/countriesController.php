<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\country;

class countriesController extends Controller
{
    public function index(Request $request)
    {
        $query = country::all();//country
        return $this->successResponse($query);
    }

    public function store(Request $request)
    {
        
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
