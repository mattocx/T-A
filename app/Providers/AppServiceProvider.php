<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Admin;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;

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
        // 🔐 Force HTTPS jika di environment 'local'
        // if ($this->app->environment('local')) {
        //     URL::forceScheme('https');
        // }

        Relation::morphMap([
            'admin' => Admin::class,
        ]);

        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_NAV_START,
            fn () => view('components.sidebar-profile')
        );
    }
}
