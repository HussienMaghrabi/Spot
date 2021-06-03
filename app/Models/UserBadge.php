<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function badge(){
        return $this->belongsTo('App\Models\Badge');
    }
}
