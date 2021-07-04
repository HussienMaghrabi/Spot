<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

   // protected $fillable = ['name','email','api_token','desc'];

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

    public function vip(){
        return $this->belongsTo('App\Models\Vip_tiers','vip_role');
    }
}
