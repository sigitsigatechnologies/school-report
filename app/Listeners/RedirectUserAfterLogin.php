<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class RedirectUserAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;

        // Simpan rute tujuan ke session
        if ($user->hasRole('guru')) {
            Session::put('url.intended', route('filament.guru.pages.dashboard'));
        } elseif ($user->hasRole('admin')) {
            Session::put('url.intended', route('filament.admin.pages.dashboard'));
        }
    }
}
