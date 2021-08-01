<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class karizma_level extends Model
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

    public function item(){
        return $this->belongsTo('App\Models\Item','item_id');
    }
}
