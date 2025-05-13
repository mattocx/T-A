<?php

namespace App\Filament\Pages\Admin;

use App\Filament\Widgets;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $slug = '/';

    protected static ?string $title = ' Welcome ';

    protected static string $view = 'filament.pages.admin.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\BrandInfo::class,
            Widgets\TotalCustomers::class,
        ];
    }
}
