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
        $allowed[] = ['vip6','vip5','vip4','vip3'];
dd($allowed);
            foreach ($allowed as $role) {
                if ($user->role == $role) {
                    return Response::allow();
                }
            }
            return Response::deny('You do not have privileges for this action.');

    }
}
