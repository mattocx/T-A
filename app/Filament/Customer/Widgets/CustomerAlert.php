<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\Widget;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;

class CustomerAlert extends Widget
{
    protected static string $view = 'filament.customer.widgets.customer-alert';

    public function mount(): void
    {
        $customer = auth()->user();

        // Cek apakah paket hampir jatuh tempo (misal 3 hari sebelum habis)
        if ($customer && method_exists($customer, 'dueDate')) {
            $dueDate = $customer->dueDate();

            if ($dueDate && $dueDate->copy()->subDays(2)->isToday()) {
                Notification::make()
                    ->title('Paket Anda Akan Segera Habis!')
                    ->body('Silakan lakukan pembayaran sebelum ' . $dueDate->format('d M Y') . '.')
                    ->danger()
                    ->persistent()
                    ->send();
            }
        }
    }

    protected int | string | array $columnSpan = 'full';
}
