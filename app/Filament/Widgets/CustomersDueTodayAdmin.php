<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomersDueTodayAdmin extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();

        $customers = Customer::with('package')->get();

        $dueTodayCount = $customers->filter(function ($customer) use ($today) {
            return $customer->dueDate()?->isSameDay($today);
        })->count();

        return [
            Stat::make('Pelanggan Jatuh Tempo Hari Ini', $dueTodayCount)
                ->description('Harus diperpanjang hari ini')
                ->color('danger')
                ->icon('heroicon-o-exclamation-circle'),
        ];
    }
}
