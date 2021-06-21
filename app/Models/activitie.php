<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activitie extends Model
{
    use HasFactory;

    protected $table = "activities";

    protected $fillable = ['name','desc','date','room_id','user_id','coin_fees'];
    public function room()
    {
        return $this->belongsTo('App\Models\Room','room_id');
    }
}
