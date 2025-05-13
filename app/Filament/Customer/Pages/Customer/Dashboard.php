<?php

namespace App\Filament\Customer\Pages\Customer;

use App\Filament\Widgets;
use App\Filament\Customer;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.customer.pages.customer.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\BrandInfo::class,
        ];
    }
}
