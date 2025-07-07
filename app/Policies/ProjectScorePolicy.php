<?php

namespace App\Policies;

use App\Models\ProjectScore;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectScorePolicy
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
    public function view(User $user, ProjectScore $projectScore): bool
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
    public function update(User $user, ProjectScore $projectScore): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectScore $projectScore): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectScore $projectScore): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectScore $projectScore): bool
    {
        return $user->hasRole('guru','super_admin');
    }
}
