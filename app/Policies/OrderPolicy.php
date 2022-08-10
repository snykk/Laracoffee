<?php

namespace App\Policies;

use App\Models\{User, Role, Order};
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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


    public function create_order(User $user)
    {
        return $user->role_id == Role::CUSTOMER_ID;
    }


    public function cancel_order(User $user, Order $order)
    {
        return $user->role_id == Role::CUSTOMER_ID && $order->user_id == $user->id;
    }


    public function edit_order(User $user, Order $order)
    {
        return $user->role_id == Role::CUSTOMER_ID && $order->user_id == $user->id;
    }


    public function reject_order(User $user)
    {
        return $user->role_id == Role::ADMIN_ID;
    }


    public function end_order(User $user)
    {
        return $user->role_id == Role::ADMIN_ID;
    }


    public function approve_order(User $user)
    {
        return $user->role_id == Role::ADMIN_ID;
    }


    public function my_real_order(User $user, Order $order)
    {
        return  $user->role_id == Role::ADMIN_ID || ($user->role_id == Role::CUSTOMER_ID && $order->user_id == $user->id);
    }


    public function upload_proof(User $user, Order $order)
    {
        return $user->role_id == Role::CUSTOMER_ID && $order->user_id == $user->id;
    }


    public function delete_proof(User $user, Order $order)
    {
        return $user->role_id == Role::CUSTOMER_ID && $order->user_id == $user->id;
    }
}
