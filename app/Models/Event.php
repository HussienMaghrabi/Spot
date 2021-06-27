<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }
}
