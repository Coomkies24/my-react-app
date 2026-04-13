<?php

namespace App\Policies;

use App\Models\Book; // <--- You MUST add this import
use App\Models\User;

class BookPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Book $book): bool
    {
        // Assuming your User model has an isAdmin() method
        return $user->isAdmin(); 
    }

    /**
     * Example: Determine if the user can update the book
     */
    public function update(User $user, Book $book): bool
    {
        return $user->isAdmin();
    }
}