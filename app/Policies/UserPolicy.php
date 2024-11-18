<?php

namespace App\Policies;

use App\Models\Post;
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
    
  
}
