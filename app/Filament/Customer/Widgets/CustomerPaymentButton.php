<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class CustomerPaymentButton extends Widget
{
    protected static string $view = 'filament.customer.widgets.customer-payment-button';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $customer = Auth::guard('customer')->user();
        $customer->load('package');

        // Cek apakah customer memiliki paket aktif
        if (!$customer->package) {
            return [
                'showPayButton' => false,
                'message' => 'Tidak ada paket yang aktif. Silakan hubungi admin.',
                'daysLeft' => null,
                'status' => 'unknown',
            ];
        }

        // Periksa apakah customer sudah memiliki pembayaran aktif
        $hasActivePayment = $customer->hasActivePayment();

        // Hitung hari yang tersisa
        $daysLeft = (int) $customer->daysLeft();

        $needsPayment = $customer->status === 'inactive';


        // Tampilkan tombol bayar jika perlu pembayaran dan tidak memiliki pembayaran aktif
        $showPayButton = $needsPayment && !$hasActivePayment;

        return [
            'showPayButton' => $showPayButton,
            'daysLeft' => $daysLeft,
            'status' => $customer->status,
            'jatuhTempo' => $customer->dueDate()?->format('d M Y'),
        ];
    }


    public static function canView(): bool
    {
        return Auth::guard('customer')->check();
    }
}
