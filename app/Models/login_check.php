<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class login_check extends Model
{
    use HasFactory;

    protected $table = "login_check";

    public function daily_gift()
    {
        return $this->hasOne(daily_gift::class,"id","last_daily_gift");
    }
}
