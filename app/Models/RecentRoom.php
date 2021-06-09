<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentRoom extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'rooms_id' => 'array'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
