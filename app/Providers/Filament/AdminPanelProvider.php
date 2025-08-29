<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\WelcomeWidget;
use App\Filament\Widgets\WelcomeWidgetP5;
use App\Http\Middleware\RestrictAdminPanelAccess;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('p5')
            ->path('p5')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            // ->resources([
            //     GuruResource::class,
            //     StudentResource::class,
            //     ProjectsResource::class,
            //     UserResource::class,
            //     ProjectScoreResource::class
            // ])
            
            ->brandName('SD BOPKRI TUREN') // ubah teks "Laravel"
            ->brandName('e-Rapor P5')
            ->favicon(asset('favicon.ico'))
            // ->brandLogo(asset('images/logo_bopkri.png')) // pasang logo sendiri (ukuran kecil misalnya 32x32px)
            // ->brandLogoHeight('3rem')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                WelcomeWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            
            ->authMiddleware([
                Authenticate::class,
                // RestrictAdminPanelAccess::class
            ]);
    }
}
