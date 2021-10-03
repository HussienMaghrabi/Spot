<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RoomMember extends Model
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

    protected $casts = [
        'follow_user' => 'array',
        'join_user' => 'array',
        'active_user' => 'array',
        'ban_enter' => 'array',
        'ban_chat' => 'array',
        'on_mic' => 'array',
        'admins' => 'array',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }

    public function active(){
        return $this->belongsTo('App\Models\User','active_user');
    }
}
