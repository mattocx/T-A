<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class CustomerAlert extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        $customer = Auth::guard('customer')->user();
        $customer->load('package');
        $customer->checkAndUpdateStatus(); // update status otomatis

        $daysLeft = (int) $customer->daysLeft(); // Dibulatkan ke bilangan bulat

        if (is_null($daysLeft)) {
            return [
                Card::make('Status Pembayaran', 'Belum ada data pemasangan')
                    ->description('Silakan hubungi admin')
                    ->color('gray'),
            ];
        }

        if ($daysLeft > 0) {
            return [
                Card::make('Status Pembayaran', "$daysLeft hari lagi")
                    ->description('Silakan lakukan pembayaran sebelum jatuh tempo')
                    ->color('success'),
            ];
        } elseif ($daysLeft === 0) {
            return [
                Card::make('Status Pembayaran', 'Hari ini!')
                    ->description('⚠️ Hari ini jatuh tempo. Segera bayar!')
                    ->color('warning'),
            ];
        } else {
            return [
                Card::make('Status Pembayaran', "Telat " . abs($daysLeft) . " hari")
                    ->description('❌ Layanan dinonaktifkan karena telat bayar.')
                    ->color('danger'),
            ];
        }
    }
}
