<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class CustomerAlert extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 1;
    }

    protected function getCards(): array
    {
        $customer = Auth::guard('customer')->user();
        $customer->load('package');
        $customer->checkAndUpdateStatus();

        $daysLeft = (int) $customer->daysLeft();

        $baseClasses = 'bg-white border-2 border-pink-600 hover:border-pink-700 hover:border-4 transform hover:scale-105 transition duration-300 rounded-lg cursor-pointer';

        if (is_null($daysLeft)) {
            return [
                Card::make('Status Pembayaran', 'Belum ada data pemasangan')
                    ->description('Silakan hubungi admin')
                    ->icon('heroicon-o-user-group')
                    ->color('gray')
                    ->extraAttributes([
                        'class' => $baseClasses,
                        'wire:click' => "\$dispatch('setStatusFilter', { filter: 'none' })",
                    ]),
            ];
        }

        if ($daysLeft > 0) {
            return [
                Card::make('Status Pembayaran', "$daysLeft hari lagi")
                    ->description('Silakan lakukan pembayaran sebelum jatuh tempo')
                    ->icon('heroicon-o-user-group')
                    ->color('success')
                    ->extraAttributes([
                        'class' => $baseClasses,
                        'wire:click' => "\$dispatch('setStatusFilter', { filter: 'ongoing' })",
                    ]),
            ];
        } elseif ($daysLeft === 0) {
            return [
                Card::make('Status Pembayaran', 'Hari ini!')
                    ->description('⚠️ Hari ini jatuh tempo. Segera bayar!')
                    ->icon('heroicon-o-user-group')
                    ->color('warning')
                    ->extraAttributes([
                        'class' => $baseClasses,
                        'wire:click' => "\$dispatch('setStatusFilter', { filter: 'due' })",
                    ]),
            ];
        } else {
            return [
                Card::make('Status Pembayaran', "Telat " . abs($daysLeft) . " hari")
                    ->description('❌ Layanan dinonaktifkan karena telat bayar.')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('danger')
                    ->extraAttributes([
                        'class' => $baseClasses,
                        'wire:click' => "\$dispatch('setStatusFilter', { filter: 'overdue' })",
                    ]),
            ];
        }
    }
}
