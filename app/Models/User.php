<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    protected $guarded = [];

    public function setPasswordAttribute($password){

        if(!empty($password)){

            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }
}
