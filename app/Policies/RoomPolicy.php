<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function room_password(User $user)
    {
        $vip_id = $user->vip['privileges'];
        $check = array_key_exists('room_password',$vip_id);
        if ($check){
            return Response::allow();
        }else {
            return Response::deny('You do not have privileges for this action.');
        }
    }

    public function can_be_kicked(User $user){

       if ( $user->vip_role == null){
           return true;

       }else{
           $vip_id = $user->vip['privileges'];
           $check = array_key_exists('anti-kick',$vip_id);
           if ($check){
               return Response::deny('You do not have privileges for this action.');
           }
           return Response::allow();
       }

    }

    public function can_be_banned_write(User $user){
        if ( $user->vip_role == null){
            return true;

        }else {
            $vip_id = $user->vip['privileges'];
            $check = array_key_exists('anti-ban-chat', $vip_id);
            if ($check) {
                return Response::deny('You do not have privileges for this action.');
            }
            return Response::allow();
        }
    }
}
