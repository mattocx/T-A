<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class CustomerPackageWidget extends Widget
{

    protected static string $view = 'filament.customer.widgets.customer-package-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 1;
    }

    public function getViewData(): array
    {
        $customer = Auth::guard('customer')->user();
        $customer->load('package');

        return [
            'package' => $customer->package,
        ];
    }

    public static function canView(): bool
    {
        return Auth::guard('customer')->check();
    }
}
