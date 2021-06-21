<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }

    public function user(){
        return $this->belongsTo('App\Models\User','owner_id');
    }
    public function category(){
        return $this->belongsTo('App\Models\category','category_id');
    }
    public function country(){
        return $this->belongsTo('App\Models\country','country_id');
    }
    public function member(){
        return $this->hasOne('App\Models\RoomMember','room_id');
    }
}
