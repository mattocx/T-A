<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Models\Admin;
use App\Notifications\CustomerAdded;
class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function afterCreate(): void
    {
        $customer = $this->record;

        $admins = Admin::all();

        foreach ($admins as $admin) {
            Notification::make()
                ->title('Pelanggan Baru')
                ->body("Pelanggan **{$customer->id}** telah didaftarkan.")
                ->success()
                ->sendToDatabase($admin); 
        }
    }
}
