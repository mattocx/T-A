<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomersDueTodayAdmin extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 1;
    }

    protected function getStats(): array
    {
        $today = Carbon::today();
        $baseClasses = 'bg-white border-2 border-pink-600 hover:border-pink-700 hover:border-4 transform hover:scale-105 transition duration-300 rounded-lg cursor-pointer';
        $customers = Customer::with('package')->get();

        $dueCount = $customers->filter(function ($customer) use ($today) {
            return $customer->dueDate()?->lte($today); // <= hari ini
        })->count();

        return [
            Stat::make('Pelanggan yang Harus Perpanjang', $dueCount)
                ->description('Paket sudah habis, perlu diperpanjang')
                ->color('danger')
                ->icon('heroicon-o-exclamation-circle')
                ->extraAttributes([
                    'class' => $baseClasses,
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
        ];
    }
}
