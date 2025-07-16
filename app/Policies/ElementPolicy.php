<?php

namespace App\Policies;

use App\Models\Element;
use App\Models\Elements;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ElementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin', 'admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Elements $element): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin', 'admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole('guru','super_admin', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Elements $element): bool
    {
        return $user->hasAnyRole('guru','super_admin', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Elements $element): bool
    {
        return $user->hasAnyRole('guru','super_admin', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Elements $element): bool
    {
        return $user->hasRole('guru','super_admin', 'admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Elements $element): bool
    {
        return $user->hasRole('guru','super_admin');
    }
}
