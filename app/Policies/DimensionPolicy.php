<?php

namespace App\Policies;

use App\Models\Dimension;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DimensionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Dimension $dimension): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Dimension $dimension): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dimension $dimension): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Dimension $dimension): bool
    {
        return $user->hasRole('guru','super_admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Dimension $dimension): bool
    {
        return $user->hasRole('guru','super_admin');
    }
}
