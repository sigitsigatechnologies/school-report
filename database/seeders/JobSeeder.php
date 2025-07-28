<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class JobSeeder extends Seeder
{
    public function run(): void
    {

        $permissions = [
            // Modul User
            'user.view',
            // 'user.create',
            // 'user.edit',
            // 'user.delete',

            // Modul Guru
            'guru.view',
            'guru.create',
            'guru.edit',
            'guru.delete',

            // Modul Project
            'project.view',
            'project.create',
            'project.edit',
            'project.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        // 1. Insert job positions
        JobPosition::insert([
            ['name' => 'Wali Kelas'],
            ['name' => 'Guru Kelas'],
            ['name' => 'Kepala Sekolah'],
            ['name' => 'Guru BK'],
        ]);

        // 2. Buat role "guru" jika belum ada
        Role::firstOrCreate(['name' => 'super admin', 'guard_name' => 'web']);
        
        // 3. Buat user baru
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('superadmin'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        $user->assignRole('super_admin');

        // 5. Ambil job_id dari "Guru Mapel"
        $job = JobPosition::where('name', 'Super Admin')->first();

        // 6. Buat guru baru
        Guru::create([
            'name' => 'Super Admin',
            'user_id' => $user->id,
            'job_id' => $job?->id,
        ]);
    }
}
