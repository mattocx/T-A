<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class BrandInfo extends Widget
{
    protected static string $view = 'filament.widgets.brand-info';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        // Bisa diakses semua panel
        return true;
    }
}
