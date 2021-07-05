<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    use HasFactory;
    
    protected $table = "messages";

    public function user_from()
    {
        return $this->belongsTo('App\Models\User','user_from','id');
    }

    public function user_to()
    {
        return $this->belongsTo('App\Models\User','user_to','id');
    }
}
