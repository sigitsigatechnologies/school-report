<?php

namespace App\Providers;

use App\Models\CapaianFase;
use App\Models\Classroom;
use App\Models\Dimension;
use App\Models\Elements;
use App\Models\Guru;
use App\Models\ParameterPenilaian;
use App\Models\ProjectDescription;
use App\Models\ProjectDetail;
use App\Models\Projects;
use App\Models\ProjectScore;
use App\Models\Role;
use App\Models\Student;
use App\Models\SubElements;
use App\Models\User;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Contracts\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}


    protected $policies = [
        Student::class => StudentPolicy::class,
        CapaianFase::class => \App\Policies\CapaianFasePolicy::class,
        Classroom::class => \App\Policies\ClassroomPolicy::class,
        Dimension::class => \App\Policies\DimensionPolicy::class,
        Elements::class => \App\Policies\ElementPolicy::class,
        Guru::class => \App\Policies\GuruPolicy::class,
        ParameterPenilaian::class => \App\Policies\ParameterPenilaianPolicy::class,
        Permission::class => \App\Policies\PermissionPolicy::class,
        ProjectDescription::class => \App\Policies\ProjectDescriptionPolicy::class,
        ProjectDetail::class => \App\Policies\ProjectDetailPolicy::class,
        ProjectScore::class => \App\Policies\ProjectScorePolicy::class,
        Projects::class => \App\Policies\ProjectsPolicy::class,
        Role::class => \App\Policies\RolePolicy::class,
        Student::class => \App\Policies\StudentPolicy::class,
        SubElements::class => \App\Policies\SubElementPolicy::class,
        User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
