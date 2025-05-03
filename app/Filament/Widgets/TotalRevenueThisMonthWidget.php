<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalRevenueThisMonthWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Mengambil semua customer yang terdaftar pada bulan ini
        $customersThisMonth = Customer::whereMonth('created_at', Carbon::now()->month)
                                       ->whereYear('created_at', Carbon::now()->year)
                                       ->get();

        // Menghitung total pendapatan berdasarkan harga paket yang dipilih
        $totalRevenue = $customersThisMonth->sum(function ($customer) {
            return $customer->package->price;  // Menambahkan harga paket yang terpilih oleh customer
        });

        return [
            Stat::make('Total Pendapatan Bulan Ini', number_format($totalRevenue, 0, ',', '.'))
                ->description('Jumlah pendapatan dari paket yang terjual')
                ->color('success')
                ->icon('heroicon-o-currency-dollar')
        ];
    }
}
