<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;

class UpdateCustomerStatus extends Command
{
    protected $signature = 'customers:update-status'; // nama perintah

    protected $description = 'Periksa dan update status pelanggan berdasarkan jatuh tempo';

    public function handle()
    {
        $this->info('Memeriksa status pelanggan...');

        Customer::all()->each(function ($customer) {
            $customer->checkAndUpdateStatus(); // manggil fungsi di model
        });

        $this->info('Status pelanggan sudah diperbarui.');
    }
}
