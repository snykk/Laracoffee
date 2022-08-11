<?php

namespace App\Policies;

use App\Models\{User, Product, Role};
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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


    public function add_product(User $user)
    {
        return $user->role_id == Role::ADMIN_ID;
    }


    public function edit_product(User $user)
    {
        return $user->role_id == Role::ADMIN_ID;
    }
}
