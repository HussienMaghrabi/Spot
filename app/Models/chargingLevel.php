<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class chargingLevel extends Model
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

    protected $table="charging_level";

    protected $fillable = ['name','level_limit','levelNo','created_at','updated_at'];

    public function gift()
    {
        return $this->belongsTo('App\Models\Gift');
    }
}
