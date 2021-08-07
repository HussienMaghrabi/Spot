<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class activitie extends Model
{
    use HasFactory;
    protected $guarded = [];

    //protected $fillable = ['name','desc','date','room_id','user_id','coin_fees','image'];

    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }

  //  protected $table = "activities";


    public function room()
    {
        return $this->belongsTo('App\Models\Room','room_id');
    }

    public function imagee()
    {
        return $this->belongsTo('App\Models\ActivityImage','image_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
