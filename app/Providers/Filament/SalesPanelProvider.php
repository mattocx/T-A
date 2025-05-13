<?php

namespace App\Providers\Filament;

use App\Filament\Resources\CustomerResource;
use Filament\Enums\ThemeMode;
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

class SalesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('sales')
            ->path('sales')
            ->colors([
                'primary' => Color::Pink,
            ])
            ->authGuard('sales')
            ->resources([
                CustomerResource::class, // Bisa akses Customer
            ])
            ->discoverResources(in: app_path('Filament/Sales/Resources'), for: 'App\\Filament\\Sales\\Resources')
            ->discoverPages(in: app_path('Filament/Sales/Pages'), for: 'App\\Filament\\Sales\\Pages')
            ->pages([
                //
            ])
            ->discoverWidgets(in: app_path('Filament/Sales/Widgets'), for: 'App\\Filament\\Sales\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                \App\Filament\Widgets\BrandInfo::class,
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
            ])
            ->viteTheme('resources/css/filament/dashboard/theme.css')
            ->defaultThemeMode(ThemeMode::Light)
            ->darkMode(false);
    }
}
