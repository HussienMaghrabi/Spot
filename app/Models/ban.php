<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ban extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function admin(){
        return $this->belongsTo('App\Models\Admin');
    }

    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }
}
