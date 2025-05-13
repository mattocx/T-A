<?php

namespace App\Filament\Sales\Pages\Sales;

use App\Filament\Widgets;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.sales.pages.sales.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\BrandInfo::class,
            Widgets\TotalCustomers::class,
        ];
    }
}
