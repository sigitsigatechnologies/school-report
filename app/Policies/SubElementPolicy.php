<?php

namespace App\Policies;

use App\Models\SubElement;
use App\Models\SubElements;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubElementPolicy
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
    public function view(User $user, SubElements $subElement): bool
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
    public function update(User $user, SubElements $subElement): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SubElements $subElement): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SubElements $subElement): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SubElements $subElement): bool
    {
        return $user->hasAnyRole('super_admin');
    }
}
