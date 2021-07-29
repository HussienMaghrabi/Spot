<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;

    protected $table = "contries";

    protected $fillable = ['name','lat','long','flag','created_at','updated_at','is_deleted'];
}
