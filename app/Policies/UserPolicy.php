<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, User $profileUser)
    {
        return $user->id === $profileUser->id;
    }
    public function curdPost(User $user, User $profileUser)
    {
        return $user->id === $profileUser->id;
    }
}
