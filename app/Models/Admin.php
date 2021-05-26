<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    //
    protected $guarded = [];

    public function setPasswordAttribute($password){

        if(!empty($password)){

            $this->attributes['password'] = bcrypt($password);
        }
    }
}
