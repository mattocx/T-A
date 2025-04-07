<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public $customerName;

    public function __construct($customerName)
    {
        $this->customerName = $customerName;
    }

    // disimpan ke database
    public function via($notifiable): array
    {
        return ['database'];
    }

    // ini yang disimpan ke database
    public function toArray($notifiable): array
    {
        return [
            'title' => 'Pelanggan Baru',
            'body' => "Pelanggan dengan nama {$this->customerName} berhasil ditambahkan.",
        ];
    }

    // agar tampil di Filament Notification Center
    public function toFilamentNotification($notifiable): FilamentNotification
    {
        return FilamentNotification::make()
            ->title('Pelanggan Baru')
            ->body("Pelanggan dengan nama **{$this->customerName}** berhasil ditambahkan.")
            ->success();
    }
}
