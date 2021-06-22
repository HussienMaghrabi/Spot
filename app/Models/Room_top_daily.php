<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_top_daily extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }

}
