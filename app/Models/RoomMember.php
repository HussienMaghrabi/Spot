<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'follow_user' => 'array',
        'join_user' => 'array'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}