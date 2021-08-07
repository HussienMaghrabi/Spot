<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'api_token' => $this->api_token,
            'birth_date' => $this->birth_date,
            'desc' => $this->desc,
            'completed' => $this->completed,
            'curr_exp' => $this->curr_exp,
            'karizma_exp' => $this->karizma_exp,
            'coins' => $this->coins,
            'gems' => $this->gems,
            'user_level' => $this->user_level,
            'karizma_level' => $this->karizma_level,
            'gender' => $this->gender,
            'country_id' => $this->country_id,
            'date_joined' => date('Y-m-d',strtotime($this->created_at)),
            'image' => $this->getImageAttribute($this->profile_pic),
            'vip_role' => $this->vip_role,
            'date_vip' => $this->date_vip,
            'created_at' => $this->created_at,
            'country_name' => $this->country()->pluck('name')->first(),
            'images'=> $this->user_image()->pluck('image'),
            'Charge_Level'=>$this->charging_level()->pluck('user_level')->first()

        ];
    }


}
