<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserBadge extends Model
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
        return $this->belongsTo('App\Models\User');
    }

    public function badge(){
        return $this->belongsTo('App\Models\Badge','badge_id');
    }
}
