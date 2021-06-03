<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomReport extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\User','reporter_id');
    }

    public function room(){
        return $this->belongsTo('App\Models\Room','reported_room');
    }
}
