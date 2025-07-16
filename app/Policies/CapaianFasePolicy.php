<?php

namespace App\Policies;

use App\Models\CapaianFase;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CapaianFasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin','admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CapaianFase $capaianFase): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin'],'admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin','admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CapaianFase $capaianFase): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin','admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CapaianFase $capaianFase): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin','admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CapaianFase $capaianFase): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CapaianFase $capaianFase): bool
    {
        return false;
    }
}
