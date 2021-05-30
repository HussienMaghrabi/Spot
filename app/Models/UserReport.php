<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    protected $guarded = [];

    public function reporterUser(){
        return $this->belongsTo('App\Models\User', 'reporter_id');
    }

    public function reportedUser(){
        return $this->belongsTo('App\Models\User', 'reported_user');
    }
}
