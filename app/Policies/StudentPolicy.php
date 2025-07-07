<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['guru', 'super_admin']);
    }

    public function view(User $user, Student $student): bool
    {
        return $user->hasAnyRole(['guru','super_admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole('guru','super_admin'); // hanya super_admin yang bisa tambah
    }

    public function update(User $user, Student $student): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->hasAnyRole('guru','super_admin');
    }
}
