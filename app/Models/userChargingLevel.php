<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userChargingLevel extends Model
{
    use HasFactory;

    protected $table = "user_charging_level";

    protected $fillable = ['user_id','earning','coins','user_level','created_at','updated_at'];

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

}
