<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
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

    public function edit_review(User $user, Review $review)
    {
        return $review->user_id == $user->id;
    }

    public function delete_review(User $user, Review $review)
    {
        return $review->user_id == $user->id;
    }
}
