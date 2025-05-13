<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;

class TotalCustomers extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        $baseClasses = 'bg-white border-2 border-pink-600 hover:border-pink-700 hover:border-4 transform hover:scale-105 transition duration-300 rounded-lg cursor-pointer';

        return [
            Card::make('Total Customer', Customer::count())
                ->description('Semua pelanggan terdaftar')
                ->color('success')
                ->icon('heroicon-o-user-group')
                ->extraAttributes([
                    'class' => $baseClasses,
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),

            Card::make('Customer Aktif', Customer::where('status', 'active')->count())
                ->description('Status aktif')
                ->color('info')
                ->icon('heroicon-o-user-plus')
                ->extraAttributes([
                    'class' => $baseClasses,
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),

            Card::make('Customer Nonaktif', Customer::where('status', 'inactive')->count())
                ->description('Status tidak aktif')
                ->color('danger')
                ->icon('heroicon-o-user-minus')
                ->extraAttributes([
                    'class' => $baseClasses,
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
        ];
    }
}
