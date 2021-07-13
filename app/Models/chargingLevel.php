<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chargingLevel extends Model
{
    use HasFactory;

    protected $table="charging_level";

    protected $fillable = ['user_id','coins','amount','type','created_at','updated_at'];
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
