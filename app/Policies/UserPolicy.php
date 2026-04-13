<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, User $targetUser): bool
    {
        // Rule: They can view it if it is THEIR account, OR if they are an admin
        return $authUser->id === $targetUser->id || $authUser->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $targetUser): bool
    {
        // Same logic for editing
        return $authUser->id === $targetUser->id || $authUser->isAdmin();
    }
}