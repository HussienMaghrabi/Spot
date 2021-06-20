<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\country;

class FilterController extends Controller
{
    // returns list of countries added by admin
    public function getCountries(){
        $query = category::all();
        return $query;
    }
    // returns list of categories added by admin
    public function getCategories(){
        $query = country::all();
        return $query;
    }
}
