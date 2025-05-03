<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;


class TotalCustomers extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Customer', Customer::count())
                ->description('Semua pelanggan terdaftar')
                ->color('success'),

            Card::make('Customer Aktif', Customer::where('status', 'active')->count())
                ->description('Status aktif')
                ->color('info'),

            Card::make('Customer Nonaktif', Customer::where('status', 'inactive')->count())
                ->description('Status tidak aktif')
                ->color('danger'),
        ];
    }
}
