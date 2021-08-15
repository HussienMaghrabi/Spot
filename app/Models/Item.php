<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
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
    public function getFileAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }

    public function user_item(){
        return $this->hasMany('App\Models\User_Item');
    }

    public function category(){
        return $this->belongsTo('App\Models\ItemCategory', 'cat_id');
    }


}
