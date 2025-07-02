<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    
    public function boot(): void
    {
        Filament::serving(function () {
            $user = auth()->user();

            if (request()->is('admin/login') && $user) {
                if ($user->hasRole('guru')) {
                    redirect('/guru')->send();
                }

                if ($user->hasAnyRole(['admin', 'super_admin'])) {
                    redirect('/admin')->send();
                }
            }
        });
    }

}
