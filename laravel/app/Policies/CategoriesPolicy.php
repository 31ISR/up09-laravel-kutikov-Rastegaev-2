<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoriesPolicy
{
    public function view()
    {
        return false;
    }

    public function viewAny()
    {
        return false;
    }

    public function create()
    {
        return false;
    }

    public function forceDelete()
    {
        return false;
    }

    public function restore()
    {
        return false;
    }

    public function update(User $user, Category $categories)
    {
        return $user->id === $categories->user_id;
    }

    public function delete(User $user, Category $categories)
    {
        return $user->id === $categories->user_id || $user->isAdmin();
    }
}