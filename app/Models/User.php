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

    public function country(){
        return $this->belongsTo('App\Models\country','country_id');
    }

    public function user_image(){
        return $this->hasOne('App\Models\UserImage');
    }

    public function charging_level(){
        return $this->hasMany('App\Models\userChargingLevel','user_id');
    }

    public function gift(){
        return $this->hasMany('App\Models\User_gifts','receiver_id');
    }
    public function badge(){
        return $this->hasMany('App\Models\UserBadge','user_id');
    }
    public function item(){
        return $this->hasMany('App\Models\User_Item','user_id');
    }


}
