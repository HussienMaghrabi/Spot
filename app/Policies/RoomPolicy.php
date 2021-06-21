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
        $vip_id = $user->vip_role->privilages;
        dd($vip_id);
        $allowed = ['vip6','vip5','vip4','vip3'];
        foreach ($allowed as $role){
        if ($user->vip_role == $role){
                return Response::allow();
            }
        }
        return Response::deny('You do not have privileges for this action.');
    }

    public function can_be_kicked(User $user){
        $allowed = ['vip6'];
        foreach ($allowed as $role){
            if ($user->vip_role == $role){
                return Response::deny('You do not have privileges for this action.');
            }
        }
        return Response::allow();
    }

    public function can_be_banned_write(User $user){
        $allowed = ['vip6','vip5'];
        foreach ($allowed as $role){
            if ($user->vip_role == $role){
                return Response::deny('You do not have privileges for this action.');
            }
        }
        return Response::allow();
    }
}
