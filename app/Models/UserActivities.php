<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserActivities extends Model
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
        return $this->belongsTo('App\Models\User','user_id',);
    }
    public function activity(){
        return $this->belongsTo('App\Models\activitie','activity_id',);
    }


}
