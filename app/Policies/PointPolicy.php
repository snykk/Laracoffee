<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PointPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function user_point(User $user)
    {
        return $user->role_id == Role::CUSTOMER_ID;
    }

    public function convert_point(User $user)
    {

        return $user->point >= 50 && $user->role_id == Role::CUSTOMER_ID;
    }
}
