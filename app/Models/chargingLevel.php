<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chargingLevel extends Model
{
    use HasFactory;

    protected $table="charging_level";

    protected $fillable = ['name','level_limit','levelNo','created_at','updated_at'];
}
