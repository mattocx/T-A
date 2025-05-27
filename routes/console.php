<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function(){
    Customer::where('status', 'active')->get()->map(function($customer) {
        $customer->load('package');
        if($customer->package) {
            $daysLeft = (int) $customer->daysLeft();
            if ($daysLeft < 0) {
                $customer->update([
                    'status' => 'inactive'
                ]);
            }
        }
    });
})->everyMinute();


Schedule::command('queue:work --timeout=60 --tries=1 --stop-when-empty')
    ->everyMinute()
    ->withoutOverlapping()
    ->sendOutputTo(storage_path().'/logs/queue.log');

Schedule::command('queue:restart')
    ->everyFiveMinutes();
