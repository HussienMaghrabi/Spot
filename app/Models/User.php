<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }

    public function setPasswordAttribute($password){

        if(!empty($password)){

            $this->attributes['password'] = bcrypt($password);
        }
    }



    public function transaction()
    {
        return $this->hasMany(Recharge_transaction::class);
    }

    public function level(){
        return $this->belongsTo('App\Models\Level','user_level','name');
    }

    public function diamond(){
        return $this->belongsTo('App\Models\Diamond','gems','req_diamond');
    }
}
