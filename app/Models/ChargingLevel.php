<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ChargingLevel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'gift_id' => 'array'
    ];


    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }

}
